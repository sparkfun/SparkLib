<?php
namespace SparkLib\Application\ControllerRole;

use \SparkLib\Application\Redirect;
use \SparkLib\Template;
use \CustomerCommentSaurus;
use \CustomerSaurus;
use \LogSaurus;
use \MongoDate;
use \MongoId;
use \MongoDBI;
use \SparkEmailer;
use \Exception;

/**
 * Let a controller handle comment functions.
 *
 * A work in progress with many dependencies outside of SparkLib.
 */
trait CommentHandler {

  /**
   * Individual comment view.  For HTML, bounces to appropriate anchor
   * on commented page.  For JSON, just dumps the comment record with
   * rendered HTML as an attribute.
   *
   * @access public
   * @return void
   */
  public function view ()
  {
    $this->req()->expect('bson');
    $comment = new CustomerCommentSaurus($this->req()->bson);

    $this->respondTo()->json = function () use ($comment) {
      $comment_record = $comment->record();
      $comment_record['html'] = $comment->getHtml();
      return $comment_record;
    };

    $this->respondTo()->html = function () use ($comment) {
      return new Redirect($comment->url());
    };
  }

  /**
   * Reply controls for a given comment.
   *
   * @access public
   * @return void
   */
  public function reply ()
  {
    $this->app()->require_authentication();
    $this->req()->expect('bson');
    $comment = null;

    try {
      $comment = new CustomerCommentSaurus($this->req()->bson);
    } catch(Exception $e) {
      $this->app()->passMessage("Comment not found");
    }

    $this->respondTo()->html = function() use ($comment) {
      $this->template()->comment = $comment;
      $this->layout()->title = 'Reply to Comment';
      return $this->layout();
    };
  }

  /**
   * Edit controls for a given comment.
   *
   * @access public
   * @return void
   */
  public function edit ()
  {
    $this->app()->require_authentication();
    $this->req()->expect('bson');
    $comment = null;
    $can_edit = false;

    try {
      $comment = new CustomerCommentSaurus($this->req()->bson);
    } catch(Exception $e) {
      $this->app()->passMessage("Comment not found");
    }

    if($comment->customer_id == $_SESSION['user']->customer()->id() || $_SESSION['user']->customer()->customer_is_moderator)
      $can_edit = true;
    else
      $this->app()->passMessage('You do not have permission to edit this comment');

    $this->respondTo()->html = function() use ($comment) {
      $this->template()->comment = $comment;
      $this->layout()->title = 'Edit Comment';
      return $this->layout();
    };
  }

  /**
   * Create a new comment.
   *
   * @access public
   * @return void
   */
  public function post ()
  {
    $status = true;
    $message = '';
    $mongo = MongoDBI::getInstance();
    $comment = [];

    try {
      $this->req()->expect('entity', 'entity_id', 'text');
    } catch(Exception $e) {
      $status = false;
      $message = 'You must provide a comment';
    }

    if(!$_SESSION['user']->isAuthenticated()) {
      $status = false;
      $message = 'You must be logged in to comment';
    }

    if(!$_SESSION['user']->customer()->can_comment) {
      $status = false;
      $message = 'Permission denied.';
    }

    if($status) {
      $parent_id = (isset($this->req()->parent_id)) ? $this->req()->parent_id : 0;

      $comment = new CustomerCommentSaurus([
        "entity_table"  => $this->req()->entity,
        "entity_id"     => $this->req()->entity_id,
        "parent_id"     => $parent_id,
        "customer_id"   => (int) $_SESSION['user']->customer()->id(),
        "customer_role" => $_SESSION['user']->customer()->customers_role,
        "ctime"         => new MongoDate(),
        "mtime"         => new MongoDate(),
        "ratings"       => [ (int) $_SESSION['user']->customer()->id() ],
        "ratings_count" => 1,
        "reports"       => 0,
        "visible"       => true,
        "text"          => $this->req()->text
      ]);

      // by default, hide replies to hidden comments, so they don't
      // wind up in the feed (if you want to quietly send a message
      // to the nerds watching the backchannel in the feed, you can
      // unhide your comment and it'll show up there)
      if ($parent_id != 0) {
        $parent_comment   = $comment->parent();
        $comment->visible = $parent_comment->visible;
      }

      // TODO: should this be $comment->insert() instead ?
      if(! $mongo->comments->insert($comment->getRecord())) {
        $status = false;
        $message = 'Error saving comment, please try again later.';
      } else {
        LogSaurus::log('COMMENT_POST', $_SESSION['user']->customer()->id(), 'COMMERCE', $comment->id());
      }

      // assuming we saved that correctly, let's notify whoever wants to know about
      // this comment being posted
      if ($status) {
        $comment->queueNotification();
      }

    }

    $this->respondTo()->json = function() use ($mongo, $status, $message, $comment) {
      if(!$status)
        return ['status' => $status, 'message' => $message];

      $updated_html = $this->app()->partial('comments/view');
      $updated_html->entity_table = $this->req()->entity;
      $updated_html->entity_id    = $this->req()->entity_id;
      $updated_html->comments = $mongo->comments->find([
        'entity_table' => $this->req()->entity,
        'entity_id'    => $this->req()->entity_id,
        // make real sure we only show visible comments here (see 4f2cdfad9):
        'visible'      => true,
      ]);
      $updated_html->comments->sort(["ratings_count" => -1, "ctime" => -1]);

      return array(
        'status'     => $status,
        'message'    => $message,
        'comment_id' => (string) $comment->id(),
        'html'       => $updated_html->render()
      );
    };

    $this->respondTo()->html = function() use ($status, $message, $comment) {
      if($status)
        return new Redirect($comment->url());
      $this->template()->message = $message;
      $this->layout()->title = 'Error posting comment';
      return $this->layout();
    };
  }

  /**
   * Hide a comment from public view (moderators only).
   *
   * @access public
   */
  public function hide ()
  {
    $this->app()->require_authentication();
    $this->req()->expect('bson');
    $status = true;
    $message = '';

    if(!$_SESSION['user']->customer()->customer_is_moderator) {
      $status  = false;
      $message = 'Only moderators can do that';
    }

    if($status) {
      $mongo = MongoDBI::getInstance();
      $mongo->comments->update(array('_id' => new MongoId($this->req()->bson)),
                               array('$set' => array('visible' => false)));
      LogSaurus::log('COMMENT_HIDE', $_SESSION['user']->customer()->id(), 'COMMERCE', $this->req()->bson);
    }

    $this->respondTo()->json = function() use ($status, $message) {
      return array("status" => true, 'message' => $message);
    };
  }

  /**
   * Show a hidden comment (moderator function).
   *
   * @access public
   * @return void
   */
  public function show ()
  {
    $this->app()->require_authentication();
    $this->req()->expect('bson');
    $status = true;
    $message = '';

    if(!$_SESSION['user']->customer()->customer_is_moderator) {
      $status  = false;
      $message = 'Only moderators can do that';
    }

    if($status) {
      $mongo = MongoDBI::getInstance();
      $mongo->comments->update(array('_id' => new MongoId($this->req()->bson)),
                               array('$set' => array('visible' => true)));
      LogSaurus::log('COMMENT_SHOW', $_SESSION['user']->customer()->id(), 'COMMERCE', $this->req()->bson);
    }

    $this->respondTo()->json = function() use ($status, $message) {
      return array("status" => true, 'message' => $message);
    };
  }

  /**
   * Rate a comment.
   *
   * @access public
   * @return void
   */
  public function rate ()
  {
    $this->app()->require_authentication();
    $this->req()->expect('bson');

    $id = new MongoId($this->req()->bson);
    $customer = $_SESSION['user']->customer();

    // toggle customers rating of this comment
    // FIXME: need to support this sort of functionality in SparkRecordMongo
    $mongo = MongoDBI::getInstance();
    if(array_key_exists($this->req()->bson, $customer->comments_rated())) {
      $mongo->comments->update(array('_id'   => $id),
                               array('$pull' => array('ratings'       => $customer->id()),
                                     '$inc'  => array('ratings_count' => -1)));
    } else {
      $mongo->comments->update(array('_id'       => $id),
                               array('$addToSet' => array('ratings'       => $customer->id()),
                                     '$inc'      => array('ratings_count' => 1)));
    }

    $comment = new CustomerCommentSaurus($id);
    $this->respondTo()->json = function() use ($comment) {
      return array("status" => true, "rating" => $comment->rating());
    };
  }

  /**
   * Report a comment to moderators.
   *
   * @access public
   * @return String json
   */
  public function report ()
  {
    $status = true;
    $message = '';

    try {
      $this->req()->expect('bson');
    } catch(Exception $e) {
      $status = false;
      $message = 'You did not provide a comment to report';
    }

    if(!$_SESSION['user']->isAuthenticated()) {
      $status = false;
      $message = 'Please log-in to report comments';
    }

    if($status) {
      $mongo = MongoDBI::getInstance();
      $comment_id = new MongoId($this->req()->bson);
      $comment = $mongo->comments->findOne(array('_id' => $comment_id));
      $mongo->comments->update(array('_id' => $comment_id),
                               array('$inc' => array('reports' => 1)));

      $this->send_report($comment);
    }

    $this->respondTo()->json = function() use ($status, $message) {
      return array('status' => $status, 'message' => $message);
    };

    $this->respondTo()->html = function() use ($comment, $status, $message) {
      $body = $this->template();
      $body->status  = $status;
      $body->message = $message;
      $body->comment = $comment;
      $this->layout()->title = 'Report Comment';
      $this->layout()->body = $body->render();

      return $this->layout();
    };
  }

  /**
   * Handle the modification of comments.
   *
   * @access public
   * @return void
   */
  public function update ()
  {
    $this->app()->require_authentication();
    $this->req()->expect('bson', 'text');

    $comment = new CustomerCommentSaurus($this->req()->bson);
    $can_edit = false;

    if ($_SESSION['user']->customer()->customer_is_moderator)
      $can_edit = true;
    else if ($comment->customer_id == $_SESSION['user']->customer()->id())
      $can_edit = true;

    if ($can_edit) {
      $comment->text = $this->req()->text;
      $comment->mtime = new MongoDate();
      $comment->update();
      LogSaurus::log('COMMENT_EDIT', $_SESSION['user']->customer()->id(), 'COMMERCE', $this->req()->bson);
    }

    $this->respondTo()->json = function() use ($comment, $can_edit) {
      $mongo = MongoDBI::getInstance();

      if (! $can_edit) {
        return ['status' => false, 'message' => 'Permission denied'];
      }

      $updated_html = $this->app()->partial('comments/view');
      $updated_html->entity_table = $comment->entity_table;
      $updated_html->entity_id    = $comment->entity_id;
      $updated_html->comments = $mongo->comments->find([
        "entity_table" => $comment->entity_table,
        "entity_id"    => $comment->entity_id,
        "visible"      => true,
      ]);
      $updated_html->comments->sort(array("ratings_count" => -1, "ctime" => -1));
      return [
        'status'     => true,
        'comment_id' => (string) $comment->id(),
        'html'       => $updated_html->render()
      ];

    };

    $this->respondTo()->html = function () use ($comment) {
      return new Redirect($comment->url());
    };
  }

  /**
   * Send an email notification for a reply
   */
  private function send ($customer, $their_comment, $the_reply)
  {
    $temp = new Template;
    $temp->setTemplateDirRel('mail');
    $temp->setTemplate('comment_reply_notify.tpl.php');
    $temp->the_reply = $the_reply;
    $temp->their_comment = $their_comment;
    $temp->alias = $customer->customers_alias;

    $emailer = new SparkEmailer();
    $emailer->AddAddress($customer->customers_email_address, $temp->alias);
    $emailer->Subject = "Reply to SparkFun Comment #" . (string) $their_comment->id();
    $emailer->MsgHTML($temp->render());

    return $emailer->Send();
  }

  private function send_report ($comment)
  {
    $naughty_customer = new CustomerSaurus($comment['customer_id']);

    $from = $_SESSION['user']->customer()->customers_email_address;
    $subject = 'Comment Report';
    $headers = "From: " . $from . "\r\n";
    $body = $_SESSION['user']->customer()->alias() . ' (customer #' . $_SESSION['user']->customer()->id() . ') has reported a comment:';
    $body .= "\n\n" . $_SERVER['HTTP_REFERER'] . "\n\n";
    $body .= 'The comment in question was posted by customer ' . $naughty_customer->alias() . ' #' . $naughty_customer->id();
    $body .= "\n\n**\n\n";
    $body .= $comment['text'];

    // TODO: use SparkEmailer?
    if(! mail(constant('\COMMENT_MODERATION_EMAIL'), $subject, $body, $headers)) {
      return [
        'status'  => false,
        'message' => 'Unable to report comment at this time, please try again later'
      ];
    }
  }

}
