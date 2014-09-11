<?php
namespace SparkLib\SparkdownMacro;
use \SparkLib\SparkdownMacro;

/**
 * A sample Sparkdown macro.
 *
 * To use this in a document, you'd do something like:
 *
 * <code>
 *   $md = Sparkdown::create('<!-- say(Hello world.) -->')->withMacros();
 *   echo $md->getHtml();
 * </code>
 *
 * Sparkdown passes everything inside the parens to the constructor of this
 * class as a string, then calls render() and displays whatever it's returned.
 * No processing is done on the string - it's up to you to parse input values
 * as-needed.
 *
 * It might seem kind of heavy to create an object instance for something
 * that's effectively a print statement, but most of the actual use cases for
 * this feature are widgets that should probably be encapsulated more than
 * programmers will encapsulate them if they're just told to write a static
 * method.
 *
 * If you want to put new Sparkdown macros in your own namespace (which you
 * probably should), you can add a call like:
 *
 * <code>
 *   $md->addMacroNamespace('\\MyNameSpace\\Sparkdown');
 * </code>
 */
class Say extends SparkdownMacro {

  public function render ()
  {
    return '<p>' . $this->_input . '</p>';
  }

}
