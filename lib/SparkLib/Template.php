<?php
namespace SparkLib;

use \SparkLib\Renderable;
use \SparkLib\Fail;

/**
 * SparkFun's approach to templating in PHP.
 *
 * A brief dialog:
 *
 *   B: Maybe we should use a template library of some sort.
 *
 *   C: Didn't we just spend all this time scrapping a bunch of Smarty
 *      templates?
 *
 *   B: You're right. This is dumb. We should just use PHP.
 *
 * So we did. This class does almost nothing at all. It's used like
 * so:
 *
 * <code>
 * // some random PHP file
 * use \SparkLib\Template;
 * $tpl = new Template('foo.tpl.php');
 * $tpl->message = 'Hello world.';
 * echo $tpl->render();
 *
 * // in foo.tpl.php
 * A message: <?= $message ?>
 * </code>
 *
 * Inside a template, the Template instance may be accessed as $this.
 * $h() is available as a wrapper around htmlspecialchars().
 */
class Template extends HTML implements Renderable {

  /**
   * Template filename.
   */
  protected $_template = null;

  /**
   * Directory to find template filename in.
   */
  protected $_templateDir;

  /**
   * Currently active template - used only during rendering.
   */
  protected $_activeTemplate = null;

  /**
   * Array of properties/variables available in template.
   */
  protected $_context = array();

  /**
   * Create a new template.
   *
   * Optionally takes a template filename and an associative array of 
   * variables to be passed into the template.
   *
   * @param string template filename
   * @param array optional array of variables to extract() before template is require'd
   * @param boolean cache template contents?
   */
  public function __construct ($template = null, $context = null)
  {
    $this->_templateDir = \LIBDIR . 'templates';
    if ($template)
      $this->setTemplate($template);
    if (is_array($context))
      $this->setContext($context);
  }

  /**
   * If you want a variable accessible inside the template, set it using
   * properties of the template object. A reference to the variable will
   * be extracted as $propertyname.
   */
  public function __set ($property, $value)
  {
    return ($this->_context[$property] = $value);
  }

  public function __get ($property)
  {
    return $this->_context[$property];
  }

  /**
   * Get the path of the current template directory.
   */
  public function getTemplateDir ()
  {
    return $this->_templateDir;
  }

  /**
   * Set a path for the template directory.
   */
  public function setTemplateDir ($dir)
  {
    return $this->_templateDir = $dir;
  }

  /**
   * Set a path for the template directory, relative to the present one.
   */
  public function setTemplateDirRel ($dir)
  {
    return $this->_templateDir = $this->_templateDir . \DIRECTORY_SEPARATOR . $dir;
  }

  /**
   * Set the whole context array at once. Overwrites any existing values.
   *
   * If given an instance of Template, will copy that template's entire
   * context.
   *
   * @return $this
   */
  public function setContext ($context = array())
  {
    if (is_array($context))
      $this->_context = $context;
    elseif ($context instanceof Template)
      $this->_context = $context->getContext();
    else
      throw new \UnexpectedValueException('context must be array or Template instance');
    return $this;
  }

  /**
   * Add a set of values to existing context. Overwrites existing values
   * if the given ones happen to overlap, leaves existing ones in place.
   *
   * If given an instance of Template, will copy that template's entire
   * context.
   *
   * @return $this
   */
  public function addContext ($context = array())
  {
    if ($context instanceof Template)
      $context = $context->getContext();

    if (! is_array($context))
      throw new \UnexpectedValueException('context must be an array or Template instance');

    foreach ($context as $key => $val) {
      $this->__set($key, $val);
    }

    return $this;
  }

  /**
   * Return a copy of the entire context array.
   */
  public function getContext ()
  {
    return $this->_context;
  }

  /**
   * Set the template file.
   *
   * If you want to use a different template directory, see setTemplateDir()
   *
   * @param string template file
   */
  public function setTemplate ($template = null)
  {
    return $this->_template = $template;
  }

  /**
   * Return filename of current template.
   */
  public function getTemplate ()
  {
    return $this->_template;
  }

  /**
   * Check if the current template file exists.
   */
  public function templateFileExists ($template = null)
  {
    if (is_null($template))
      $template = $this->_template;
    return file_exists($this->getPath($template));
  }

  /**
   * Render a template. Optionally take a filename to render,
   * otherwise use the one set in the constructor.
   */
  public function render ($template = null)
  {
    // Use $this->_activeTemplate to avoid collisions with variables
    // extracted into the current scope from $this->_context
    $this->_activeTemplate = $template ?: $this->_template;

    try {
      // Start an output buffer, slurp a template, kill the buffer
      \ob_start();
        $this->slurp($this->_activeTemplate);
        $output = \ob_get_contents();
      \ob_end_clean();

      $this->_activeTemplate = null;
      return $output;
    } catch (Exception $e) {
      Fail::log($e);
      throw $e;
    }
  }

  /**
   * Wrap render() to return a string if the template object is used in
   * string context.  It is probably safest to avoid relying on this
   * behavior - an exception thrown here will result in a fatal error.
   */
  public function __toString ()
  {
    return $this->render();
  }

  /**
   * Render a template with an alternative variable substitution
   * syntax, rather than executing it as PHP.
   *
   * Unless you're doing some kind of PHP code generation, you
   * probably don't want or need to use this.
   */
  public function preprocess ($template = null)
  {
    // Use $this->_activeTemplate to avoid collisions with variables
    // extracted into the current scope from $this->_context
    $this->_activeTemplate = $template ?: $this->_template;

    try {
      $output = \file_get_contents($this->_templateDir . \DIRECTORY_SEPARATOR . $this->_activeTemplate);
      $this->_activeTemplate = null;

      $pattern = array();
      $replace = array();
      foreach($this->_context as $key => $val) {
        if(\is_string($val)) {
          $pattern[] = '/::' . $key . '::/';
          $replace[] = $val;
        }
      }
      $output = \preg_replace($pattern, $replace, $output);

      return $output;
    } catch (\Exception $e) {
      Fail::log($e);
      throw $e;
    }
  }

  /**
   * Eval the contents of a template file or a cached copy of same,
   * with extracted variables in the current scope.
   *
   * May be used inside templates to include other templates.
   *
   * @param string template filename
   */
  protected function slurp ($template)
  {
    // TODO:  This can theoretically get overwritten by a 'filename' key
    // in the context array.  There has to be some clever way around this.
    $filename = $this->getPath($template);

    // Pull context variables, as references, into this scope.
    // Try not to change things inside templates - IT WILL BITE YOU.
    \extract($this->_context, \EXTR_REFS);

    if (! isset($h)) {
      $h = function ($text) { return \htmlspecialchars($text); };
    }

    if (! isset($p)) {
      $p = function ($price) {
        $class = 'price';
        if ($price < 0)
          $class = 'price neg';
        return '<span class="' . $class . '">'
             . \htmlspecialchars(\number_format((double)$price, 2, '.', '')) . '</span>';
      };
    }

    require $filename;
  }

  /**
   * Get a path for a template.
   */
  protected function getPath ($template)
  {
    return $this->_templateDir . \DIRECTORY_SEPARATOR . $template;
  }

  /**
   * Output a PDF file to a given filename.
   *
   * @param filespec optional path to output file
   */
  public function outputPDF ($filespec = null)
  {
    if (! class_exists('\DOMPDF'))
      throw new \Exception('DOMPDF appears to be unavailable.');

    $pdf = new \DOMPDF();
    $pdf->load_html($this->render());
    $pdf->render();

    if (strlen($filespec) > 0) {
      \file_put_contents($filespec, $pdf->output());
    } else {
      return $pdf->output();
    }
  }

  /**
   * Output a PDF stream to the browser with the given filename.
   *
   * @param $name the filename with which the browser will be presented.
   * @param $options DOMPDF&stream() options.
   *
   * This will send the pdf as a document to be opened by default.
   * Set $options['Attachment'] = 1 if you wish the browser to present
   * a "Save As" dialog box.
   *
   * Other $optionss are: (copied from DOMPDF documentation)
   *
   * 'Accept-Ranges' => 1 or 0 - if this is not set to 1, then this
   *    header is not included, off by default this header seems to
   *    have caused some problems despite the fact that it is supposed
   *    to solve them, so I am leaving it off by default.
   *
   * 'compress' = > 1 or 0 - apply content stream compression, this is
   *    on (1) by default
   *
   */
  public function streamPDF ($name = 'output.pdf', $options = null)
  {
    if (! class_exists('\DOMPDF'))
      throw new \Exception('DOMPDF appears to be unavailable.');

    $pdf = new \DOMPDF();
    $pdf->load_html($this->render());
    $pdf->render();

    if (\headers_sent()) {
      throw new \RuntimeException(
        'Cannot stream template as PDF since headers have already been sent.'
      );
    }

    if (! isset($options['Attachment']))
      $options['Attachment'] = 0;

    $pdf->stream($name, $options);
  }

  /**
   * Generate an HTML table row from parameters.
   *
   * If the first parameter is a callback, treat it as an anonymous
   * iterator function which will spit out a class name for the row on
   * each call. (See iterator(), below, for a quickie way to get one
   * of these.)
   *
   * Will also work with an array.
   */
  protected function tableRow ()
  {
    $args = func_get_args();
    $html = '';

    if ((func_num_args() >= 2) && is_callable($args[0])) {
      // callback for class
      $striper = array_shift($args);
    } elseif ((func_num_args() === 1) && is_array($args[0])) {
      // array instead of multiple params
      $args = $args[0];
    }

    foreach ($args as &$cell) {
      $html .= '<td>' . $cell . '</td>';
    }

    return isset($striper)
      ? '<tr class="' . $striper() . '">' . $html . '</tr>'
      : '<tr>' . $html . '</tr>';
  }

  /**
   * Return an anonymous function which will iterate through its
   * parameters. Useful for stuff where you want to rotate through,
   * say, CSS class names or other little blobs of text. Useful with
   * tableRow(), above.
   */
  protected function iterator ()
  {
    $list = func_get_args();
    $last = count($list) - 1;
    $i    = 0;

    return function () use (&$i, &$list, &$last) {
      if ($i > $last)
        $i = 0;
      return $list[$i++];
    };
  }

}
