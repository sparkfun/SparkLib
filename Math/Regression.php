<?php

namespace SparkLib\Math;

use \SparkLib\Math\Matrix;

/**
 * Regression - a tool for applying regression curves to data sets
 * 
 * @author Chris Clark <cclark@sparkfun.com>
 *
 * BASIC USAGE
 *
 * $reg = new Regression($data);
 * $reg->generateAllCurves();
 *
 * This applies regression curves of six basic types to your data set and
 * automatically selects the most accurate curve based on least squares distance
 * to the data set.  From here you can evaluate the most accurate projection
 * at any x value point like so:
 *
 * $reg->evaluateMostAccurateCurve($x);
 *
 * All mathematical functions for solving and evaluating each of the six supported
 * regression curve types (methods) are contained within and fully public so that
 * this class may be used for any other algebraic application thereof.
 * 
 */

class Regression {

  // Base data set - the array of points upon which we want to fit a regression curve.
  public $base_data_set = array();

  // Active methods
  public static $active_methods = array('exponential',
                                        'linear',
                                        'logarithmic',
                                        'polynomial2',
                                        'polynomial3',
                                        'power');

  // Array for storing generated curves
  public $curves = array();

  // String for the most accurate generated method
  public $most_accurate_method;

  // Boolean for whether or not to store mapping values when doing accuracy calculation.
  // Storing these values is only necessary when the base regression curve is to be displayed
  // and saves the script doing the work from having to generate those values twice.
  public $store_mapping = false;

  /**
   * Constructor
   * @param $data_set - an array of cartesian coordinates formatted like so:
   *        $data_set = array( array(X1, Y1),
   *                           array(X2, Y2),
   *                           array(X3, Y3),
   *                           ...);
   *        Coordinates in $data_set need not be in any particular order as
   *        they will be sorted by ascending x values immediately.
   *
   * @param $skip_verification - verification includes making sure the provided data set is
   *                             well populated and consistent in order to produce a usable
   *                             projection (e.g. a set with one point would fail verification).
   *                             Set this to true for large data sets known to be good to save
   *                             processing time.
   *
   * @param $store_mapping -  set true to store mapping values when doing accuracy calculation.
   */
  public function __construct ($data_set = array(), $skip_verification = false, $store_mapping = false){

    // If directed to skip verification apply the passed data set straight to the base.
    if ($skip_verification){
      $this->base_data_set = $data_set;
      return;
    }

    if ($store_mapping)
      $this->store_mapping = true;

    // Must be an array
    if (!is_array($data_set))
      throw new Exception ("Data set must be an array");

    // Each element must be of the form array(X, Y) where X and Y are numeric
    // Since data sets can be large and scattered we throw out malformed points
    // instead of throwing an exception and halting (So one bad point out of
    // 4000 doesn't prevent us from getting our curves).
    $verified_data_set = array();
    foreach ($data_set as $p => $point){
      if (!is_array($point)) continue;
      $verified_point = array();
      if (isset($point[0]) && is_numeric($point[0])) $verified_point[0] = (float)$point[0];
      if (isset($point[1]) && is_numeric($point[1])) $verified_point[1] = (float)$point[1];
      if (count($verified_point) == 2) $verified_data_set[] = $verified_point;
    }

    // Must have at least three points after the last step
    if (count($verified_data_set) < 3)
      throw new Exception ("Data set must have at least three points");

    $this->base_data_set = $verified_data_set;

  }

  // function verifyMethod()
  // Verifies the method string passed is in the active methods array (does so by
  // throwing an exception if it is not)
  private function verifyMethod($method = ''){

    if (!in_array($method, self::$active_methods))
      throw new Exception("Projection method is not currently active");

  }


  // function generateAllCurves()
  // Generates regression curves for all active methods on the base data set.
  // Also determines accuracy and quality ratings for all curves and identifies the best method.
  // Quality utilizes $quality_calibration which is compared against the aggregate distance
  // derived by the accuracy calculation. It's usually best to just use the maximum value from
  // the data set. A $quality_calibration of 0 will be ignored.
  public function generateAllCurves($quality_calibration = 0){

    foreach (self::$active_methods as $method){

      $this->curves[$method] = array();
      $this->curves[$method]['coefficients'] = $this->calculateCoefficients($method);
      $this->curves[$method]['accuracy']     = $this->calculateAccuracy($method, $this->curves[$method]['coefficients']);
      $this->curves[$method]['quality']      = $this->determineQuality($this->curves[$method]['accuracy'], $quality_calibration);

      if (!strlen($this->most_accurate_method))
        $this->most_accurate_method = $method;
      else if ($this->curves[$method]['accuracy'] < $this->curves[$this->most_accurate_method]['accuracy'])
        $this->most_accurate_method = $method;

    }

  }


  // function calculateCoefficients()
  // Helper function that will take a method string and a data array and pass the data
  // to the appropriate coefficient calculator function for the method
  public function calculateCoefficients($method = ''){

    $this->verifyMethod($method);

    switch ($method){
      case 'exponential':
        return $this->calculateExponentialCoefficients();
        break;
      case 'linear':
        return $this->calculateLinearCoefficients();
        break;
      case 'logarithmic':
        return $this->calculateLogarithmicCoefficients();
        break;
      case 'polynomial2':
        return $this->calculatePolynomialCoefficients(2);
        break;
      case 'polynomial3':
        return $this->calculatePolynomialCoefficients(3);
        break;
      case 'power':
        return $this->calculatePowerCoefficients();
        break;
      default:
        throw new Exception("Projection method is active but coefficient calculation function does not exist");
        break;
    }
      
  }


  // function calculateAccuracy()
  // Accepts a method string, method coefficients, and a data array and evaluates the regression
  // curve at all values present in the data array, taking the absolute value of the distance and
  // summing them. This is the accuracy rating. In a nutshell: the accuracy rating is the distance
  // between the regression curve and the data set.  Smaller accuracy rating means a better fit.

  public function calculateAccuracy($method = '', $coefficients = array()){

    $this->verifyMethod($method);

    $rating = 0;

    if ($this->store_mapping)
      $this->curves[$method]['data_map'] = array();

    for ($i = 0; $i < count($this->base_data_set); $i++){
      $value    = array($this->base_data_set[$i][0], $this->evaluateCurve($method,$this->base_data_set[$i][0]));
      $distance = abs( $value[1] - $this->base_data_set[$i][1] );
      $rating  += $distance;
      if ($this->store_mapping)
        $this->curves[$method]['data_map'][$i] = $value;
    }

    return $rating;

  }


  // function determineQuality()
  // Rates quality by comparing accuracy to a quality calibration (usually the max value
  // in the data set). Values of 0 for a calibration don't make sense so return 'unknown'.
  // A rating of excellent or good means the accuracy of the graph is within the 1.5 times
  // the magnitude of the quality calibration

  private function determineQuality($accuracy = 0, $quality_calibration = 0){

    if ($quality_calibration == 0)
      return 'unknown';

    if ($accuracy <= $quality_calibration * 0.5)
      return 'excellent';
    else if ($accuracy <= $quality_calibration * 1.5)
      return 'good';
    else if ($accuracy <= $quality_calibration * 4)
      return 'mediocre';
    else
      return 'total crap';

  }


  // function evaluateMostAccurateCurve()
  // Helper function that will take a single x value and pass it to evaluateCurve using the
  // most accurate method string
  public function evaluateMostAccurateCurve($x = 0){

    return $this->evaluateCurve( $this->most_accurate_method,
                                 $x );

  }

  // function evaluateCurve()
  // Helper function that will take a method string and an x value and pass the data
  // to the appropriate curve evaluation function for the method
  public function evaluateCurve($method = '', $x = 0){

    $this->verifyMethod($method);

    switch ($method){
      case 'exponential':
        return self::evaluateExponentialCurve($this->curves[$method]['coefficients'], $x);
        break;
      case 'linear':
        return self::evaluateLinearCurve($this->curves[$method]['coefficients'], $x);
        break;
      case 'logarithmic':
        return self::evaluateLogarithmicCurve($this->curves[$method]['coefficients'], $x);
        break;
      case 'polynomial2':
      case 'polynomial3':
        return self::evaluatePolynomialCurve($this->curves[$method]['coefficients'], $x);
        break;
      case 'power':
        return self::evaluatePowerCurve($this->curves[$method]['coefficients'], $x);
        break;
      default:
        throw new Exception("Projection method is active but evaluation function does not exist");
        break;
    }

  }


  // function solveMostAccurateCurve()
  // Helper function that will take a single y value and pass it to solveCurve using the
  // most accurate method string and coefficients
  // Regarding the nature of $domain_min and $domain_max values see the comment for function solveCurve().
  public function solveMostAccurateCurve($y = 0, $domain_min = 0, $domain_max = 10){

    return $this->solveCurve( $this->most_accurate_method,
                              $this->curves[$this->most_accurate_method]['coefficients'],
                              $y,
                              $domain_min,
                              $domain_max );

  }

  // function solveCurve()
  // Helper function that will take a method string, an array of coefficients, and a y value
  // and pass the data to the appropriate curve solving function for the method.
  // NOTE 1: For polynomial functions an array of values may be returned.
  // NOTE 2: Sometimes the explicit inverse functions for some methods can only be solved with imaginary numbers.
  //         rather than implement that the inverse is instead calculated using a brute-force approach that iterates
  //         through evaluated integer values of x within a definable domain and interpolates linearly to find a
  //         close approximation. Whenever using this method be sure to set the $domain_min and $domain_max to a range
  //         that is likely to contain your solution.
  public function solveCurve($method = '', $coefficients = array(), $y = 0, $domain_min = 0, $domain_max = 10){

    $this->verifyMethod($method);

    switch ($method){
      case 'exponential':
        return self::solveExponentialCurve($coefficients, $y);
        break;
      case 'linear':
        return self::solveLinearCurve($coefficients, $y);
        break;
      case 'logarithmic':
        return self::solveLogarithmicCurve($coefficients, $y);
        break;
      case 'polynomial2':
      case 'polynomial3':
        $x = self::solvePolynomialCurve($coefficients, $y);
        if (is_array($x) || (is_numeric($x) && !is_nan($x)))
          return $x;
        else
          return self::solvePolynomialCurveByBruteForce($coefficients, $y, $domain_min, $domain_max, .2);
        break;
      case 'power':
        return self::solvePowerCurve($coefficients, $y);
        break;
      default:
        throw new Exception("Projection method is active but evaluation function does not exist");
        break;
    }

  }


  /* PROJECTION METHOD: EXPONENTIAL */

  // function calculateExponentialCoefficients()
  // Calculates a fit curve for the data set of the form y = A * e^(B * x)
  public function calculateExponentialCoefficients(){

    $n         = count($this->base_data_set);
    $sig_y     = 0;
    $sig_xy    = 0;
    $sig_x2y   = 0;
    $sig_ylny  = 0;
    $sig_xylny = 0;

    for ($i = 0; $i < $n; $i++){
      $lny        = ( $this->base_data_set[$i][1] == 0 ? -10 : log($this->base_data_set[$i][1]) );
      $sig_y     += $this->base_data_set[$i][1];
      $sig_xy    += $this->base_data_set[$i][0] * $this->base_data_set[$i][1];
      $sig_x2y   += pow($this->base_data_set[$i][0],2) * $this->base_data_set[$i][1];
      $sig_ylny  += $this->base_data_set[$i][1] * $lny; 
      $sig_xylny += $this->base_data_set[$i][0] * $this->base_data_set[$i][1] * $lny;
    }

    $a = ( ($sig_x2y * $sig_ylny) - ($sig_xy * $sig_xylny) ) / ( ($sig_y * $sig_x2y) - pow($sig_xy,2) );
    $b = ( ($sig_y * $sig_xylny) - ($sig_xy * $sig_ylny) ) / ( ($sig_y * $sig_x2y) - pow($sig_xy,2) );

    return array( 'A' => exp($a),
                  'B' => $b );

  }

  // function evaluateExponentialCurve()
  // Evaluates a curve of the form form y = A * e^(B * x)
  public static function evaluateExponentialCurve($coefficients = array(), $x = 0){

    return $coefficients['A'] * exp($coefficients['B'] * $x);

  }

  // function solveExponentialCurve()
  // Solves a curve of the form y = A * e^(B * x) for x at a given y ( x = ln(y/A)/B )
  public static function solveExponentialCurve($coefficients = array(), $y = 0){

    if ($coefficients['A'] == 0 || $coefficients['B'] == 0 || $y == 0)
      return null;
    else
      return log($y / $coefficients['A']) / $coefficients['B'];

  }



  /* PROJECTION METHOD: LINEAR */

  // function calculateLinearCoefficients()
  // Calculates a fit curve for the data set of the form y = m * x + b
  public function calculateLinearCoefficients(){

    $n      = count($this->base_data_set);
    $sig_x  = 0;
    $sig_y  = 0;
    $sig_xy = 0;
    $sig_x2 = 0;

    for ($i = 0; $i < $n; $i++){
      $sig_x  += $this->base_data_set[$i][0];
      $sig_y  += $this->base_data_set[$i][1];
      $sig_xy += $this->base_data_set[$i][0] * $this->base_data_set[$i][1];
      $sig_x2 += pow($this->base_data_set[$i][0],2);
    }

    $m = ( ($n * $sig_xy) - ($sig_x * $sig_y) ) / ( ($n * $sig_x2) - pow($sig_x,2) );
    $b = ( ($sig_y * $sig_x2) - ($sig_x * $sig_xy) ) / ( ($n * $sig_x2) - pow($sig_x,2) );

    return array( 'm' => $m,
                  'b' => $b );

  }

  // function evaluateLinearCurve()
  // Evaluates the y value of a curve of the form y = m * x + b for a given x
  public static function evaluateLinearCurve($coefficients = array(), $x = 0){

    return ($coefficients['m'] * $x) + $coefficients['b'];

  }

  // function solveLinearCurve()
  // Solves a curve of the form y = m * x + b for x at a given y ( x = (y-b)/m )
  public static function solveLinearCurve($coefficients = array(), $y = 0){

    if ($coefficients['m'] == 0)
      return null;
    else
      return ($y - $coefficients['b']) / $coefficients['m'];

  }



  /* PROJECTION METHOD: LOGARITHMIC */

  // function calculateLogarithmicCoefficients()
  // Calculates a fit curve for the data set of the form y = a + b * ln x
  public function calculateLogarithmicCoefficients(){

    $n        = count($this->base_data_set);
    $sig_y    = 0;
    $sig_lnx  = 0;
    $sig_lnx2 = 0;
    $sig_ylnx = 0;
    
    for ($i = 0; $i < count($this->base_data_set); $i++){
      $lnx       = ( $this->base_data_set[$i][0] == 0 ? -10 : log($this->base_data_set[$i][0]) );
      $sig_y    += $this->base_data_set[$i][1];
      $sig_lnx  += $lnx;
      $sig_lnx2 += pow($lnx,2);
      $sig_ylnx += $this->base_data_set[$i][1] * $lnx;
    }
    
    $b = ( ($n * $sig_ylnx) - ($sig_y * $sig_lnx) ) / ( ($n * $sig_lnx2) - pow($sig_lnx,2) );
    $a = ( $sig_y - ($b * $sig_lnx) ) / $n;
    
    return array( 'a' => $a,
                  'b' => $b );

  }

  // function evaluateLogarithmicCurve()
  // Evaluates a curve of the form y = a + b * ln x
  public static function evaluateLogarithmicCurve($coefficients = array(), $x = 0){

    return $coefficients['a'] + $coefficients['b'] * log($x);

  }

  // function solveLogarithmicCurve()
  // Solves a curve of the form  y = a + b * ln x for x at a given y ( x = e^((y-a)/b) )
  public static function solveLogarithmicCurve($coefficients = array(), $y = 0){

    if ($coefficients['b'] == 0)
      return null;
    else 
      return exp( ($y - $coefficients['a']) / $coefficients['b'] );

  }


  /* PROJECTION METHOD: POLYNOMIAL */

  // function calculatePolynomialCoefficients()
  // Calculates a fit curve for the data set of the form y = a0 + a1*x + a2*x^2 + ... am*x^m where m = $order
  //
  // @param $order integer for the degree of the polynomial
  public function calculatePolynomialCoefficients($order = 2){

    $n = count($this->base_data_set);
    $m = $order;

    $sig_xKy = array();
    for ($i = 0; $i <= $m; $i++){
      $sig_xKy[$i] = 0;
    }

    $sig_xK  = array();
    for ($i = 0; $i <= (2*$m); $i++){
      $sig_xK[$i] = 0;
    }

    for ($i = 0; $i < count($this->base_data_set); $i++){
      for ($j = 0; $j <= $m; $j++){
        $sig_xKy[$j] += $this->base_data_set[$i][1] * pow($this->base_data_set[$i][0],$j);
      }
      for ($j = 0; $j <= (2*$m); $j++){
        $sig_xK[$j] += pow($this->base_data_set[$i][0],$j);
      }
    }

    $matrix_X_array = array();
    for ($r = 0; $r <= $m; $r++){
      for ($c = 0; $c <= $m; $c++){
        $matrix_X_array[$r][$c] = $sig_xK[$r+$c];
      }
    }
    $X = new matrix($matrix_X_array, $m, $m);
    unset($matrix_X_array);
    unset($sig_xK);

    $matrix_Y_array = array();
    for ($r = 0; $r <= $m; $r++){
      $matrix_Y_array[$r][0] = $sig_xKy[$r];
    }
    $Y = new matrix($matrix_Y_array, $m, 1);
    unset($matrix_Y_array);
    unset($sig_xKy);

    $XT = $X->prime();
    $A  = $XT->times($X)->inv()->times($XT)->times($Y);
    $A_content = $A->get_data();

    unset($X); unset($Y); unset($XT); unset($A);

    $ret = array('m' => $m);
    for ($r = 0; $r <= $m; $r++){
      if (isset($A_content[$r]))
        $ret['a'.$r] = $A_content[$r][0];
    }
    
    return $ret;

  }

  // function evaluatePolynomialCurve()
  // Evaluates a curve of the form y = a0 + a1*x + a2*x^2 + ... am*x^m where m is a required coefficient
  public static function evaluatePolynomialCurve($coefficients = array(), $x = 0){

    $y = 0;
    for ($i = 0; $i <= $coefficients['m']; $i++){
      $y += $coefficients['a'.$i] * pow($x,$i);
    }
    return $y;

  }

  // function solvePolynomialCurve()
  // Solves a curve of the form  y = a0 + a1*x + a2*x^2 + ... am*x^m for x at a given y
  public static function solvePolynomialCurve($coefficients = array(), $y = 0){

    switch ($coefficients['m']){

      // solve linear (order 1)
      case 1:
        return self::solveLinearCurve( array('m' => $coefficients['a1'],
                                             'b' => $coefficients['a0']), $y );
        break;

      // solve quadratic (order 2)
      case 2:
        $a = $coefficients['a2'];
        $b = $coefficients['a1'];
        $c = $coefficients['a0'] - $y;
        if ($a == 0)
          return null;
        else {
          $pos = ( (-1*$b) + sqrt( pow($b,2)-(4*$a*$c) ) ) / (2*$a);
          $neg = ( (-1*$b) - sqrt( pow($b,2)-(4*$a*$c) ) ) / (2*$a);
          if ($pos == $neg)
            return $pos;
          else
            return array($pos, $neg);
        }
        break;

      // solve cubic (order 3)
      case 3:
        $a = $coefficients['a3'];
        $b = $coefficients['a2'];
        $c = $coefficients['a1'];
        $d = $coefficients['a0'] - $y;
        if ($a == 0) {
          unset($coefficients['a3']);
          $coefficients['m'] = 2;
          return self::solvePolynomialCurve($coefficients, $y);
        } else {
          $discriminant = (18*$a*$b*$c*$d) - (4*pow($b,3)*$d) + (pow($b,2)*pow($c,2)) - (4*$a*pow($c,3)) - (27*pow($a,2)*pow($d,2));
          $Q = sqrt(-27 * pow($a,2) * $discriminant);
          $D = pow($b,2) - (3*$a*$c);
          if ($D == 0){
            if ($Q == 0)
              $x = -$b / (3*$a);
            else {
              $Qpos = abs($Q);
              $Qneg = abs($Q) * -1;
              $C_Qpos = self::cuberoot(0.5*( $Qpos + (2*pow($b,3)) - (9*$a*$b*$c) + (27*pow($a,2)*$d)));
              $C_Qneg = self::cuberoot(0.5*( $Qneg + (2*pow($b,3)) - (9*$a*$b*$c) + (27*pow($a,2)*$d)));
              if (!is_nan($C_Qpos) && ($C_Qpos != 0)) $C = $C_Qpos;
              if (!is_nan($C_Qneg) && ($C_Qneg != 0)) $C = $C_Qneg;
              $x = (-$b/(3*$a)) - ($C/(3*$a)) - ( (pow($b,2)-(3*$a*$c)) / (3*$a*$C) );
            }
          } else {
            if ($Q == 0){
              $x = array();
              $x[] = (($b*$c) - (9*$a*$d)) / (2 * ((3*$a*$c) - pow($b,2)));
              $x[] = ((9*pow($a,2)*$d) - (4*$a*$b*$c) + pow($b,3)) / ($a * ((3*$a*$c) - pow($b,2)));
            } else {
              $C = (2*pow($b,3)) - (9*$a*$b*$c) + (27*pow($a,2)*$d);
              $Rpos = self::cuberoot(0.5*($C+$Q));
              $Rneg = self::cuberoot(0.5*($C-$Q));
              $x = (-$b/(3*$a)) - ( (1/(3*$a)) * $Rpos ) - ( (1/(3*$a)) * $Rneg );
            }
          }
        }
        return $x;
        break;

      // can't solve anything higher without some serious mathematical gymnastics.
      default:
        return null;
        break;

    }

  }

  // function solvePolynomialCurveByBruteForce()
  // Solves a curve of the form  y = a0 + a1*x + a2*x^2 + ... am*x^m for x at a given y using a brute force
  // approach by evaluating the curve at integer values of x within a defined domain and interpolating linearly
  // between bounding values to get an approximate solution to two decimal places. If no solution is found, returns 'unknown'.
  public static function solvePolynomialCurveByBruteForce($coefficients = array(), $y = 0, $domain_min = 0, $domain_max = 10, $step = 1){
   
    $evals = 'SOLVE FOR Y = ' . $y . "\n";

    // When PHP does a lot of this floating point math our equivalence comparisons can drift by a tiny margin.
    // Tolerance is introduced as a function of the step size to round off our bound comparisons so that a
    // difference of a billionth of a point does not cause equivalence to fail and produce an incorrect result.
    $tolerance = abs(min(round(log10($step))-5,-1));

    $lower_bound_x = $domain_min;
    $upper_bound_x = $domain_max;
    $lower_bound_y = 0;
    $upper_bound_y = 0;

    if ((float)$step <= 0)
      $step = 1;

    $ret = '';

    $x = $domain_min;
    while ($lower_bound_x <= $domain_max){

      $f_x =  self::evaluatePolynomialCurve($coefficients, $x);

      if ($x == $domain_min){
        if ($f_x > $y)
          return 0;
        $lower_bound_x = $x;
        $lower_bound_y = $f_x;
      }

      $ret .= round($f_x,$tolerance) . ' ?== ' . round($y,$tolerance) . "\n";

      if (round($f_x,$tolerance) == round($y,$tolerance)){
        return $x;
      } else if ($f_x < $y){
        $lower_bound_x = $x;
        $lower_bound_y = $f_x;
      } else {
        $upper_bound_x = $x;
        $upper_bound_y = $f_x;
        break;
      }

      $x += $step;

    }

    if (round($lower_bound_x,$tolerance) == round($upper_bound_x,$tolerance))
      return 'unknown';

    else 
      return round( $lower_bound_x + ($y - $lower_bound_y) / ($upper_bound_y - $lower_bound_y), 2 );

  }



  /* PROJECTION METHOD: POWER */

  // function calculatePowerCoefficients()
  // Calculates a fit curve for the data set of the form y = A * x^B
  public function calculatePowerCoefficients(){

    $n          = count($this->base_data_set); 
    $sig_lnx    = 0;
    $sig_lnx2   = 0;
    $sig_lny    = 0;
    $sig_lnxlny = 0;
    
    for ($i = 0; $i < count($this->base_data_set); $i++){
      $lnx         = ( $this->base_data_set[$i][0] == 0 ? -10 : log($this->base_data_set[$i][0]) );
      $lny         = ( $this->base_data_set[$i][1] == 0 ? -10 : log($this->base_data_set[$i][1]) );
      $sig_lnx    += $lnx;
      $sig_lnx2   += pow($lnx,2);
      $sig_lny    += $lny;
      $sig_lnxlny += $lnx * $lny;
    }
    
    $b = ( ($n * $sig_lnxlny) - ($sig_lnx * $sig_lny) ) / ( ($n * $sig_lnx2) - pow($sig_lnx,2) );
    $a = ( $sig_lny - ($b * $sig_lnx) ) / $n;
    
    return array( 'A' => exp($a),
                  'B' => $b );

  }

  // function evaluatePowerCurve()
  // Evaluates a curve of the form y = A * x^B
  public static function evaluatePowerCurve($coefficients = array(), $x = 0){

    return $coefficients['A'] * pow($x, $coefficients['B']);

  }

  // function solvePowerCurve()
  // Solves a curve of the form y = A * x^B for x at a given y ( x = (y/A)^(1/B) )
  public static function solvePowerCurve($coefficients = array(), $y = 0){
    
    if ($coefficients['A'] == 0 || $coefficients['B'] == 0)
      return null;
    else 
      return pow( $y / $coefficients['A'], 1 / $coefficients['B'] );

  }

  public static function cuberoot($base){
    $root = pow(abs($base),1/3);
    if ($base < 0) $root *= -1;
    return $root;
  }


}

?>
