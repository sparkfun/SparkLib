<?php
namespace SparkLib;

use \MarkdownDocument;

/**
 * Wrap up all our usage of Markdown libraries.
 *
 * Basic usage is like so:
 *
 *     echo Sparkdown::create($source)
 *       ->allowHtmlTags() // optional - probably in-house only - let HTML through
 *       ->withCallbacks() // optional - in-house only for now - install callbacks for link shorthand
 *       ->withMacros()    // optional - implies allowHtmlTags() - add a filter to do <!-- foo(bar) --> macros
 *
 *       // optional - adds an additional namespace besides SparkLib\SparkdownMacro to search for macro classes:
 *       ->addMacroNamespace('\\SomeNameSpace\\SparkdownMacro')
 *
 *       ->getHtml()
 *
 * If you have something like a model object and you're going to want
 * to render it with the same options in more than one place, you may
 * want to write a getHtml() wrapper method on that object instead of
 * repeating the Sparkdown boilerplate.
 */
class Sparkdown {

  protected $_md;

  protected $_allowHTML       = false;
  protected $_macros          = false;
  protected $_macroNamespaces = ['\\SparkLib\\SparkdownMacro'];
  protected $_macroContext    = [];

  /**
   * Create a new Sparkdown document from a given source string.
   */
  public static function create ($source)
  {
    return new static($source);
  }

  /**
   * Transform a fragment (not necessarily a complete document) of Markdown.
   *
   * Useful for displaying truncated bits of full documents.
   */
  public static function transformFragment ($source)
  {
    return MarkdownDocument::transformFragment($source, MarkdownDocument::NOHTML);
  }

  public function __construct ($source)
  {
    $this->_md = MarkdownDocument::createFromString($source);
  }

  /**
   * Toggle pass-through on HTML tags.  This is turned off by default
   * so that no one will use it on user-supplied data and accidentally
   * allow arbitrary HTML from the outside world.
   *
   * @return Sparkdown
   */
  public function allowHtmlTags ($allow = true)
  {
    if (! is_bool($allow)) {
      throw new Exception('allowHtmlTags() expects a boolean true/false');
    }

    if ((! $allow) && $this->_macros)
      throw new Exception('withMacros() requires that HTML tags are allowed');

    $this->_allowHTML = $allow;
    return $this;
  }

  /**
   * Install some callbacks to override link stuff.
   *
   * Right now, these are only for inhouse users.  We can expand
   * on this for different sets of users etc.
   *
   * @return Sparkdown
   */
  public function withCallbacks ()
  {
    $this->_md->setUrlCallback(function ($path) {
      return $this->urlCallback($path);
    });
    return $this;
  }

  /**
   * Set a callback for nofollow attributes on links
   *
   * @return Sparkdown
   */
  public function setNoFollow ()
  {
    $this->_md->setAttributesCallback(function () {
      return $this->attributesCallback(['rel' => 'nofollow']);
    });
    return $this;
  }

  /**
   * Return a path for special shorthand in links.
   *
   * New link shorthand should be defined here, following the pattern
   * currently used for tutorials.
   *
   * A hook for this can be installed by withCallbacks().
   */
  protected function urlCallback ($path)
  {
    $m = [];
    if (preg_match('/^tutorials?\/([0-9]+)$/', $path, $m)) {
      if ($t = \LearnTutorialSaurus::getById($m[1])) {
        return \Learn::externalLink('tutorials')->id($t->url_path);
      }
    }

    // we didn't find anything
    return null;
  }

  /**
   * Return a rel=nofollow for links
   *
   * An example hook for this can be seen at setNoFollow().
   */
  protected function attributesCallback ($attributes)
  {
    if (is_array($attributes)) {
      $attr_str = '';
      foreach($attributes as $k => $v) {
        $attr_str .= $k . '="' . $v . '" ';
      }
      return $attr_str;
    } else if (is_string($attributes)) {
      return $attributes;
    }

    // unknown attribute type
    return null;
  }

  /**
   * Toggle processing macros of the form <!-- macro(param string) -->
   *
   * Implies allowHtmlTags().
   *
   * @return Sparkdown
   */
  public function withMacros ()
  {
    // necessary for comments to pass through:
    $this->allowHtmlTags();
    $this->_macros = true;
    return $this;
  }

  /**
   * Add a namespace to search for macro classes.
   *
   * @return Sparkdown
   */
  public function addMacroNamespace ($namespace)
  {
    array_unshift($this->_macroNamespaces, $namespace);
    return $this;
  }

  /**
   * Set a context array to be passed to macros.
   */
  public function setMacroContext (array $context)
  {
    $this->_macroContext = $context;
    return $this;
  }

  /**
   * Get the current macro context array.
   */
  public function getMacroContext ()
  {
    return $this->_macroContext;
  }

  /**
   * Get the HTML version of the current document.
   *
   * @return string
   */
  public function getHtml ()
  {
    if ($this->_allowHTML) {
      $this->_md->compile();
    } else {
      $this->_md->compile(MarkdownDocument::NOHTML);
    }

    if ($this->_macros) {
      return $this->getHtmlWithMacros();
    } else {
      return $this->_md->getHtml();
    }
  }

  /**
   * Get the HTML version of the current document, with
   * <!-- module(param string) --> macros processed.
   * Should only be invoked by getHtml() after the document
   * has been compiled.
   *
   * @return string
   */
  protected function getHtmlWithMacros ()
  {
    $pat = '/
      <!-- [ ] # open comment

        (?<name> [_a-z]+) # macro name

        \(
          (?<input> .*?) # params
        \)

      [ ] -->  # close comment
    /x';

    $transform = function ($matches) {
      foreach ($this->_macroNamespaces as $ns) {
        $class = $ns . '\\' . ucfirst($matches['name']);
        if ($class_exists = class_exists($class))
          break;
      }

      if (! $class_exists)
        return '';

      $macro = new $class($matches['input']);
      $macro->setContext($this->_macroContext);
      return $macro->render();
    };

    // call $transform() on everything matching $pat in the rendered HTML:
    return preg_replace_callback($pat, $transform, $this->_md->getHtml());
  }

}
