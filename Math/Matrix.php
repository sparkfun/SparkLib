<?php

namespace SparkLib\Math;

/** 
* A class to perform operation on matrices. 
*
* Modified : 19/dec/2009 by Pier-AndrÃ© Bouchard St-Amant pabsta [at]Â econ.queensu.ca
*
* Changes : 
*  - Introduction of the PLU decomposition of square matrices (through lu() for users, and PLU internally)
*  - Significant improvement in stability and speed for inversion and the computation of the determinant (based on the above).
*  - The "matrix" constructor can now take one or three arguments. The two additionnal arguments are the number of rows and the number of columns.
*  - Bug correction in many functions : dimensions where incorrect after many routines if a matrix had a full column/row of zeros.
*  - Corrections in "get_columns"
*  - See the file "changes.php" for the whole history of changes.
*
*  - Comments :
*    - All mathematical functions are written to ressemble paper algebra : 
*        - AxB ==>Â $A->times($B);
*        - A-B ==>Â $A->minus($B);
*        - A^(-1) ==>Â $A->inv();
*        - A' ==> $A->prime();
*        - det(A) ==>Â $A->det($A);
*        - etc.
*    - This restricts nested calls, but augment readability.
*    - The algorithm for matrix inversion is based on PLU decomposition. The algorithm performs relatively well numerically and requires an order of 
*       2*n^2 xsizeof(doubles) of memory space.
*    - Error messages are echoed to the standard output (likely to be your webpage)
*/
class matrix
{

  //Global vars
  /**
  *  The array containing the numbers of the matrix. 
  *  $numbers[$i][$j] is a two dimensional array where $i represents the depth and $j the width. Hence, $numbers[$i] returns one row of the matrix.
  *  As a convention, zeros are not stored in the array. Thus, the dimension of the array is not necessarely the dimension of the matrix.
  */
  var $numbers = array();
  
  /**
  * The number of columns in this matrix.
  */
  var $numColumns = 0;
  
  /**
  * The number of rows in this matrix.
  */
  var $numRows = 0;
  
  /**
   * Class contructor.
   *
   * The constructor either take one or three arguments. With only one argument, the arrow of numbers, the constructor sets the dimension of the 
   * matrix as the dimensions of the array. In the three argument version, the constructor sets the dimension to those specified. This may be     
   * necessary since some columns/rows full of zeros may not be returned by some internal computations. This may also be useful to creat a matrix of 
   * zeros by the user. 
   *
   * If the number of rows and the number of columns are specified, those must be equal or greater than the actual number of rows ans columns of
   * the array as otherwise, the constructor will set the array values. 
   *
   * @param array $numbers, [int $numRows, int $numColumns] the array of numbers and the dimensions of the matrix.
   * @return The new matrix
   */
  function __construct()
  {
    //See which information is passed as arguments.
    $nArgs = func_num_args();
    $numbers = func_get_arg(0);

    if($nArgs > 2) //If the three arguments version, set the values.
    {
      $this->numRows = func_get_arg(1);
      $this->numColumns = func_get_arg(2);
    }
    
    //Routine to initialise the array of numbers.
    $numberColumns = 0;
    $numberRows = 0;

    if(empty($numbers) == false) //If the array is not empty
    {        
      foreach($numbers as $i => $rows) //Check every row...
      {
        foreach($rows as $j => $number) //...and column to remove zeros.
        {
          if($number != 0)
          {
            $this->numbers[$i][$j] = $number; 
          }
          //Find the biggest width of the array.      
          if($j >= $numberColumns) 
          {
            $numberColumns = $j;
          }
        }
        //Find the biggest depth of the array.
        if($i >= $numberRows)
        {
          $numberRows = $i;
        }
      }
      //Arrays starts at zero (so we add one)
      $numberRows++;
      $numberColumns++;
    }
    
    //If the user misspecified the number of rows/columns by a lower value. 
    if($numberRows > $this->numRows) 
    {
      $this->numRows = $numberRows;
    }
    
    if($numberColumns > $this->numColumns)
    {
      $this->numColumns = $numberColumns;
    }
  }
  
  /**
  * Quasi-constructor for an identity matrix.
  *
  * Creates an $n x $m matrix with ones on the main diagonal and zeros elsewhere. 
  * 
  * @param int $n, int $m the depth and width of the matrix.
  * @return The matrix
  */
  function eye($n, $m)
  {    
    $dim = min($n, $m);
    for($i = 0; $i < $dim; $i++)
    {
      $id_numbers[$i][$i] = 1; 
    }
    
    $the_identity_matrix = new matrix($id_numbers, $n, $m);
    
    return $the_identity_matrix;
  }

  /**
  * Quasi-constructor of a matrix of zeros.
  *
  * Creates an $n x $m matrix with zeros everywhere.
  *
  * @param int $n, int $m the depth and width of the matrix.
  * @return The matrix
  */
  function zeros($n, $m)
  {
    $the_zero_matrix = new matrix(array(), $n, $m);
    
    return $the_zero_matrix;
  }
  
  /**
  * Quasi-constructor of a matrix of ones
  *
  * Creates an $n x $m matrix with ones everywhere.
  *
  * @param int $n, int $m the depth and width of the matrix.
  * @return The matrix
  */
  function ones($n, $m)
  {
    $ones = array();
    
    for($i = 0; $i < $n; $i++)
    {
      for($j = 0; $j < $m; $j++)
      {
        $ones[$i][$j] = 1; 
      }
    }
    
    $a_matrix_of_ones = new matrix($ones);
    
    return $a_matrix_of_ones;
  }

  /**
  * Quasi-constructor of a matrix of random numbers
  *
  * Creates an $n x $m matrix with random numbers. The numbers are taken from the inside PHP random number generator and normalised so to have a uniform
  * distribution.
  *
  * @param int $n, int $m the depth and width of the matrix.
  * @return The matrix
  */
  function random($n, $m)
  {
    $random_numbers = array();
    
    for($i = 0; $i < $n; $i++)
    {
      for($j = 0; $j < $m; $j++)
      {
        $random_numbers[$i][$j] = rand(0,100)/100; 
      }
    }
    
    $the_random_matrix = new matrix($random_numbers, $n, $m);
    return $the_random_matrix;
  }

  /**
   * Set all the numbers of this matrix
   * This changes the actual numbers of this matrix to the specified arguments. The dimensions of the matrix are changed to those of the array passed as an
   * argument.
   *
   * @param array $numbers the numbers of the matrix
   */
  function set_data($numbers)
  {
    $a = new matrix($numbers);
    $this->numbers = $a->numbers;
    $this->numRows = $a->numRows;
    $this->numColumns = $a->numColumns;
  }
  
  /**
   * Get the all the numbers of the matrix.
   *
   * Get the array of numbers of the matrix, including zeros.
   *
   * @return The array of numbers of the matrix.
   */
  function get_data()
  {
    $the_numbers = array();
    for($i = 0; $i < $this->numRows; $i++)
    {
      for($j = 0; $j < $this->numColumns; $j++)
      {
        if(empty($this->numbers[$i][$j]) == false)
        {
          $the_numbers[$i][$j] = $this->numbers[$i][$j];
        }
        else
        {
          $the_numbers[$i][$j] = 0;
        }
      }
    }
    return $the_numbers;
  }

  /**
   * Get a particular element of the matrix
   *
   * Pre-requisite : The values of $i and $j must be smaller than the dimensions (rows/columns). $i and $j are indexed from one. Hence get_value(1,1) returns the
   * value of the first element (in the upper left corner). If the pre-requisite is not met, an error message will be echoed to the standard output.
   *
   * @param : int $i, int $j the index of the particular element.
   * @return The number requested OR zero if the parameters $i, $j are invalid.
   */
  function get_value($i, $j)
  {
    $the_value = 0;
    if($i-1 < $this->get_num_rows() and $j-1 < $this->get_num_columns())
    {
      if(empty($this->numbers[$i-1][$j-1]) == false)
      {
        $the_value = $this->numbers[$i-1][$j-1];  
      }
    }
    else
    {
      echo "<br><br>\n\n\nWrong parameters in get_value !\n\n\n\<br><br>";
    }
    
    return $the_value;
  }
  
  /**
   * Set a particular element of the matrix
   *
   * Pre-requisite : The values of $i and $j must be smaller than the dimensions (rows/columns). $i and $j are indexed from one. Hence set_value(1,1, 0) sets the
   * value of the first element (in the upper left corner) to zero. If the pre-requisite is not met, an error message will be echoed to the standard output.
   *
   * If there is an error in indexes, no value will be changed. 
   *  
   * @param : int $i, int $j, double $value the coordinates of the element and the new value.
   */
  function set_value($i, $j, $value)
  {
    if($i-1 < $this->get_num_rows() and $j-1 < $this->get_num_columns())
    {
      if($value != 0 )
        {
          $this->numbers[$i-1][$j-1] = $value;
        }
        else
        {
          unset($this->numbers[$i-1][$j-1]);
        }
    }
    else
    {
      echo "<br><br>\n\n\nWrong parameters in set_value !\n\n\n\<br><br>";
    }
  }

  /**
   * Get the number of rows. 
   *
   * @return The number of rows of this matrix.
   */
  function get_num_rows()
  {
    return $this->numRows;
  }

  /**
   * Get the number of columns
   *
   * @return The number of columns of this matrix.
   */
  function get_num_columns()
  {
    return $this->numColumns;
  }
  
  /**
   * Get some rows of the matrix
   *
   * Returns a matrix containing all the rows inclusively contained in the range $start to $stop.
   *
   * Pre-requisite : $start and $stop must be inclusiveley between one an the number of rows of this matrix. If not, an error message will be echoed to the
   * standard output
   *
   * @param int $start, int $stop the range of requested rows
   * @return The matrix generated by those rows OR a 1x1 matrix with a zero if there is an error in the range of requested rows.
   */
  function get_rows($start, $stop) 
  {  
    if($start-1 < $this->get_num_rows() and $stop - 1 < $this->get_num_rows())
    {
      
      for($i = $start-1; $i < $stop; $i++)
      {
        if(empty($this->numbers[$i]) == false)
        {
          $the_rows_array[$i - $start + 1] = $this->numbers[$i];
        }
      }
      $the_rows = new matrix($the_rows_array);
    }
    else
    {
      echo "<br><br>Invalid indexes in get_rows<br><br>";
      $the_rows = $this->zeros(1,1);
    }
    return $the_rows;
  }
  
  /**
   * Get some columns of the matrix
   *
   * Returns a matrix containing all the columns inclusively contained in the range $start to $stop.
   *
   * Pre-requisite : $start and $stop must be inclusiveley between one an the number of columns of this matrix. If not, an error message will be echoed to the
   * standard output.
   *
   * @param int $start, int $stop the range of requested rows
   * @return The matrix formed by the requested columns OR a 1x1 matrix with a zero if there is an error in the range of requested columns.
   */
  function get_columns($start, $stop) 
  {
    if($start-1 < $this->get_num_columns() and $stop - 1 < $this->get_num_columns())
    {
      $toto = $this->prime();
      $the_columns = $toto->get_rows($start, $stop);
      $the_columns = $the_columns->prime();
    }
    else
    {
      echo "<br><br>Invalid indexes in get_columns<br><br>";
      $the_columns = $this->zeros(1,1);
    }
    return $the_columns;
  }
  
  /**
   * Replace some rows of the matrix
   *
   * Changes the rows specified in the inclusive range of $start and $stop by $bloc_matrix
   *
   * Pre-requisite : $start and $stop must be inclusiveley between one an the number of columns of this matrix. If not, an error message will be echoed to the
   * standard output. If there is an error, no values will be changed.
   * 
   * Note that no requirements are necessary on $block_matrix. If it is smaller in any dimension, this will be interpreted as filling the missing values with
   * zeros. If the matrix is bigger, only the necessary values will be taken, starting from the upper-left corner. 
   *
   * @param int $start, int $stop, matrix $block_matrix the range and the matrix to use for modifications.
   */
  function set_rows($start, $stop, $block_matrix)
  {
    if($start-1 < $this->get_num_rows() and $stop < $this->get_num_rows())
    {
      if($bloc_matrix->get_num_columns() == $this->get_num_columns())
      {
        for($i = $start-1; $i< $stop; $i++)
        {
          $this->numbers[$i] = $block_matrix->numbers[$i-$start-1];
        }
      }
    }
    else
    {
      echo "<br><br>Invalid indexes in set_rows<br><br>";
    }
  }
  
  
  /**
   * Replace some columns of the matrix
   *
   * Changes the columns specified in the inclusive range of $start and $stop by $bloc_matrix
   *
   * Pre-requisite : $start and $stop must be inclusiveley between one an the number of columns of this matrix. If not, an error message will be echoed to the
   * standard output. If there is an error, no values will be changed.
   * 
   * Note that no requirements are necessary on $block_matrix. If it is smaller in any dimension, this will be interpreted as filling the missing values with
   * zeros. If the matrix is bigger, only the necessary values will be taken, starting from the upper-left corner. 
   *
   * @param int $start, int $stop, matrix $block_matrix the range and the matrix to use for modifications.
   */
  function set_columns($start, $stop, $block_matrix) 
  {
    if($start-1 < $this->get_num_columns() and $stop < $this->get_num_columns())
    {
      if($bloc_matrix->get_num_rows() == $this->get_num_rows())
      {
        $toto = $this->prime();
        $the_columns = $toto->get_rows($start, $stop, $block_matrix->prime());
        $toto = $the_columns->prime();
        $this->numbers = $thoto->numbers;
      }
    }
    else
    {
      echo "<br><br>Invalid indexes in set_columns<br><br>";
    }
  }
  
  /**
   * Delete some rows of the matrix
   *
   * Deletes the rows specified in the inclusive range of $start and $stop.
   *
   * Pre-requisite : $start and $stop must be inclusiveley between one an the number of columns of this matrix. If not, an error message will be echoed to the
   * standard output. If there is an error, no values will be changed.
   * 
   * @param int $start, int $stop the range of rows to be deleted.
   */
   function delete_rows($start, $end)
   {
     if($start <= $this->get_num_rows() and $stop <= $this->get_num_rows() and $start > 0 and $start <= $end)
     {
      $p=0;  
      for($i = $start-1; $i < $end; $i++)
      {
        unset($this->numbers[$i]);
      }
      for($i = $start; $i < $this->numRows; $i++)
      {
        if(empty($this->numbers[$i]) == false)
        {
          $this->numbers[$i - ($end - $start + 1)] = $this->numbers[$i];
          unset($this->numbers[$i]);
        }
        
      }
      $this->numRows -= ($end - $start + 1);
    }
    else
    {
      echo "<br><br>Invalid indexes in delete_rows<br><br>";
    }
   }
   
  /**
   * Delete some columns of the matrix
   *
   * Deletes the columns specified in the inclusive range of $start and $stop.
   *
   * Pre-requisite : $start and $stop must be inclusiveley between one an the number of columns of this matrix. If not, an error message will be echoed to the
   * standard output. If there is an error, no values will be changed.
   * 
   * @param int $start, int $stop the range of the columns to be deleted.
   */
   function delete_columns($start, $end)
   {
     if($start <= $this->get_num_columns() and $end <= $this->get_num_columns() and $start > 0 and $start <= $end)
    {
      $toto = $this->prime();
      $toto->delete_rows($start, $end);
      $toto = $toto->prime();

      $this->numbers = $toto->numbers;
      $this->numColumns = $toto->numColumns;
      $this->numRows = $toto->numRows;
    }
    else
    {
      echo "<br><br>Invalid indexes in delete_columns<br><br>";
    }
   }
   
   /**
   * Obtain the upper triangular part of this matrix.
   *
   * This returns a matrix with all the original numbers of the matrix above the principal diagonal and with zeros elsewhere.
   *
   * @return The upper diagonal matrix.
   **/
   function utrig()
   {
     $utrig = new matrix($this->numbers);
     
     for($i = 0; $i < $utrig->get_num_rows(); $i++)
     {
       for($j = 0; $j < $utrig->get_num_columns(); $j++)
       {
         if($i >= $j)
         {
           unset($utrig->numbers[$i][$j]);
         }
       }
     }
   
     return $utrig;
   }
   
  /**
   * Obtain the lower triangular part of this matrix.
   *
   * This returns a matrix with all the original numbers of the matrix below the principal diagonal and with zeros elsewhere.
   *
   * @return The lower diagonal matrix.
   **/
   function ltrig()
   {
     $ltrig = new matrix($this->numbers);
     
     for($i = 0; $i < $ltrig->get_num_rows(); $i++)
     {
       for($j = 0; $j < $ltrig->get_num_columns(); $j++)
       {
         if($i <= $j)
         {
           unset($ltrig->numbers[$i][$j]);
         }
       }
     }
   
     return $ltrig;
   }
   
   
   
   /**
    * Obtain the diagonal of the matrix OR form a diagonal matrix with a supplied vector.
    *
    * Two possible usages : 
    *  - Without any arguments : Obtain the elements on the main diagonal of the matrix.
    *  - With a vertical matrix argument : Form a matrix with the vertical matrix on the diagonal.
    *
    * If any other number of arguments is supplied, the function will echo an error message.
    * 
    *  Pre-requisite : 
    *  - Without any arguments : the matrix must be square
    *  - With a vertical matrix argument : the parameter must be an 1 x n matrix (a vertical matrix).
    *
    * If the pre-requisites are not met, an error message will be echoed to the standard output.
    *
    * @return 
    *  - Without any arguments : an n x 1 matrix with the diagonal elements of this matrix. 
    *   - With a vertical matrix : a square matrix with the 1 x n matrix on the principal diagonal.
    *   - If any error, a 1 x 1 matrix with a zero.
    */
   function diag()
   {
     if(func_num_args() == 1)
     {
       $vector = func_get_arg(0);
       if($vector->get_num_columns() == 1 or $vector->get_num_rows() == 1)
       {
         if($vector->get_num_columns() == 1)
         {
           $vector->prime();
         }
         
         for($i = 0; $i < $vector->get_num_columns(); $i++)
         {
           if($i != 0)
           {  
             $vector->numbers[$i][$i] = $vector->numbers[0][$i];
             unset($vector->numbers[0][$i]);
           }
         }
         $vector->numRows = $vector->numColumns;
         
         $diag_matrix = $vector->prime();
       }
       else
       {
         echo "Wrong vector argument in diag function !<br><br>";
         $diag_matrix = $this->zeros(1,1);
       }
     }
     elseif(func_num_args() == 0)
     {
       if($this->is_square())
       {
         for($i = 0; $i < $this->get_num_columns(); $i++)
         {
           if(empty($this->numbers[$i][$i]) == false)
           {
             $diag_data[$i][0] = $this->numbers[$i][$i];
           }
           
         }
         $diag_matrix = new matrix($diag_data, $this->get_num_rows(), 1);
       }
       else
       {
         echo "This matrix is not square for diag function !<br><br>";
         $diag_matrix = $this->zeros(1,1);
       }
     }
     else
     {
       echo "Wrong arguments in the diag function !<br><br>";
       $diag_matrix = $this->zeros(1,1);
     }
     
     return $diag_matrix;
   }
   

  /**
   * Check if two matrices are of the same size.
   *
   * E.g. : checks if they both have the same number of rows and columns.
   *
   * @param matrix $someMatrix the matrix to compare with this matrix.
   * @return bool true or false depending on if they are of the same size or not.
   */
  function size_eq($someMatrix)
  {
    $return = false;
      
    if ($someMatrix->get_num_rows() == $this->get_num_rows() and $someMatrix->get_num_columns() == $this->get_num_columns())
    {
      $return = true;
    }
      
    return $return;
  }
    

  /**
   * Check if a matrix is square.
   *
   * E.g. : if the number of rows is equal to the number of columns.
   *
   * @return bool true or false, depending on the result of the test.
   */
  function is_square()
  {
    $return = false;
    if ($this->get_num_rows() == $this->get_num_columns())
    {
       $return = true;
    }
    
       
    return $return;
  }


  /**
   * Substract $someMatrix from this matrix.
   *
   * A - B is $A->minus($B)
   *
   * Pre-requisite: Both matrices must have the same size. If not, an error message will be echoed to standard output.
   *
   * @param matrix $someMatrix the matrix to substract.
   * @return The matrix resulting of the substraction OR a matrix of zeros if the pre-requisite is not met.
   */
  function minus($someMatrix)
  {
    $substract = $this->zeros($this->get_num_rows(), $this->get_num_columns());
    if($this->size_eq($someMatrix))
    {
      for($i = 0; $i < $this->get_num_rows(); $i++)
      {   
        for($j = 0; $j < $this->get_num_columns(); $j++)
        {
          if(empty($this->numbers[$i][$j]) == false)
          {
            if(empty($someMatrix->numbers[$i][$j]) == false)
            {
              $substract->numbers[$i][$j] = $this->numbers[$i][$j] - $someMatrix->numbers[$i][$j];
            }
            else
            {
              $substract->numbers[$i][$j] = $this->numbers[$i][$j];
            }
          }
          else
          {
            if(empty($someMatrix->numbers[$i][$j]) == false)
            {
              $substract->numbers[$i][$j] = -1*$someMatrix->numbers[$i][$j];
              
            }
          }
          
        }
      }
    }
    else
    {
      echo "\n\n\n Wrong dimensions in matrix substraction \n\n\n";
    }
    return $substract;
  }
  
  /**
   * Add $someMatrix to this matrix
   *
   * A + B is $A->plus($B)
   *
   * Pre-requisite: Both must have the same size. Otherwise, an error message is echoed to the standard output.
   *
   * @param matrix $someMatrix, the matrix to add.
   * @return The matrix resulting of the addition OR a matrix of zeros if the pre-requisite is not met.
   */
  function plus($someMatrix)
  {  
    $add = new matrix($this->numbers, $this->get_num_rows(), $this->get_num_columns());
     
    if($this->size_eq($someMatrix))
    {

      $someMatrix = $someMatrix->s_times(-1);
      $add = $this->minus($someMatrix);
      
    }
    else
    {
      echo "\n\n\n Wrong dimensions in matrix addition \n\n\n";
    }
    
    return $add;
  }  
  


  /**
   * Multiply this matrix by $someMatrix
   *
   * A x B is $A->times($B)
   *
   * Pre-requiste : the number of columns of this matrix $this must equal the number of rows of $someMatrix. Otherwise, an error message is echoed to the standard
   * output. 
   *
   * @param numbers $someMatrix the matrix to multiply.
   * @return The result of the matrix product OR a matrix of zeros if the pre-requisite is not met.
   */
  function times($someMatrix) 
  {
    $easier = $someMatrix->prime();
    
    if($this->get_num_columns() == $someMatrix->get_num_rows())
    {  
      foreach($this->numbers as $i => $row) 
      {  
        foreach($easier->numbers as $j => $column)
        {
          $total = 0;
          foreach($row as $k => $number)
          {
            if(empty($column[$k]) == false)
            {
              $total += $number * $column[$k];
            }        
          }
          $the_product_data[$i][$j] = $total;
        }
      }
      $the_product = new matrix($the_product_data);
    }
    else
    {
      echo "\n\n\n Wrong dimensions in matrix multiplication \n\n\n";
      $the_product = $this->zeros(1,1);
    }
    return $the_product;
  }

  /**
   * Multiply this matrix by some scalar.
   *
   * A x scalar is $A->s_times($scalar)
   *
   * @param double $value
   */
  function s_times($value) 
  {  
    $the_matrix = new matrix($this->numbers, $this->get_num_rows(), $this->get_num_columns());
    foreach($this->numbers as $i => $column)
    {
      foreach($column as $j => $number)
      {
        $the_matrix->numbers[$i][$j] *= $value;
      }
    }
    
    return $the_matrix;
  }
  
  /**
   * Compute the determinant of some matrix
   *
   * Pre-requisite: the matrix must be square
   *
   * This function computes the determinant of the matrix through a PLU decomposition. Hence, it computes the product of the main diagonal of the U matrix.
   *
   * @param matrix $someMatrix
   * @return int $the_determinant 
   */
  function det($someMatrix) 
  {
    $the_determinant = 0;    
    if($someMatrix->is_square())
    {
      $the_determinant = 1;
        $PLU = $someMatrix->PLU();
        for($j = 0; $j < $this->get_num_rows(); $j++)
        {
          $the_determinant =  $the_determinant * $PLU['LU'][$j][$j];
        }
        $the_determinant = $the_determinant * $PLU['P_set'];
    }    
    return $the_determinant;
  }


  /**
   * Finds a minor matrix. 
   *
   * A "minor matrix" is the matrix which corresponds to deleting a specified row and column of the original matrix.
   *
   * Pre-requisite : the $column and $row values must be within the existing range of this matrix. Otherwise, an error message will be echoed to the standard
   * output.
   *
   * @param matrix $someMatrix, int $column, int $row that is, the matrix from which we seek the minor matrix, the column and the row to delete.
   * @return The minor matrix OR a matrix of zeros if the pre-requisite is not met.
   */
  function minor_matrix($someMatrix, $column, $row) 
  {
    $the_result = new matrix($someMatrix->numbers);
    $the_result->delete_rows($row, $row);
    $the_result->delete_columns($column, $column);
    return $the_result;
  }


  /**
   * Compute the transpose of this matrix
   *
   * E.g. : A_ij becomes A_ji 
   *
   * A' is $A->prime() 
   *
   * @return The transposed matrix.
   */
  function prime() 
  {  
    foreach($this->numbers as $i => $row)
    {
      foreach($row as $j => $number)
      {
        $the_transpose_data[$j][$i] = $number;
      }
    }
    $the_transpose = new matrix($the_transpose_data, $this->get_num_columns(), $this->get_num_rows());
    
    return $the_transpose;
  }

  /**
   * Smoothe the elements of this matrix to zero
   *
   * All elements within (-$tolerance, $tolerance) are set to zero.
   *
   * @param : $tolerance
   *  
   */
  function smoothe($tolerance)
  {
    foreach($this->numbers as $i => $row)
    {
      foreach($row as $j => $number)
      {
        if(abs($number)<$tolerance)
        {
          unset($this->numbers[$i][$j]);
        }
      }
    }
  }

  /**
   * Compute the inverse of this matrix
   *
   * This is done in a few steps : 
   *  - Find the PLU decomposition of the matrix. That is find P, L and U where P is a permutation matrix, L is a lower diagonal matrix with ones on the diagonal
   *  and U is an upper triangular matrix such that P*L*U is the original matrix. (See the private function PLU)
   *  - Check if the determinant is non-null. An error is echoed to the standard output otherwise.
   *  - Perform the inversion of U, L, and P (which is much faster).
   *  - Multiply the inverted results to find the inverse of the original matrix.
   *
   * Pre-requisite : this matrix is invertible.
   *  
   * @return The inverse matrix OR a matrix of zeros if the pre-requisite is not met.
   */
  function inv() 
  {  
    $inv = array();
    if($this->is_square())
    {
      $n = $this->get_num_rows();
      $the_determinant = 1;
        $PLU = $this->PLU();
        $inv = $PLU['LU'];
        for($j = 0; $j < $this->get_num_rows(); $j++)
        {
          $the_determinant *=  $PLU['LU'][$j][$j];
        }
        $the_determinant = $the_determinant * $PLU['P_set'];
        
      if($the_determinant != 0)
      {
      
        //Perform the inversion algorithm. 
        for($i = 0; $i < $n; $i++)
        {
          //Inverse of the main diagonal of U
          $inv[$i][$i]  = 1/$PLU['LU'][$i][$i];        
        }
        //For each diagonal except the principal...
        for($i = 1; $i < $n; $i++)
        {  
          //Now, for each element of this diagonal... (there are $n - $i of them)
          for($j = 0; $j < $n - $i; $j++)
          {
            //For all elements of this row from this element to the principal diagonal
            //Except the first one
            //(there are $i-1 of them)
            $temp1 = 0; 
            $temp2 = 0;
            for($k = 0; $k <= $n; $k++)
            {
              //We start with the elements of L
              if($k > $j and $k <= $i + $j)
              {
                if($k == $i + $j)
                {
                  $temp1 -= $PLU['LU'][$k][$j];
                }
                else
                {  
                  $temp1 -= $inv[$i+$j][$k]*$PLU['LU'][$k][$j];
                }
              }
              
              //And then U
              if($k >= $j and $k < $i + $j)
              {
                $temp2 -= $inv[$j][$k] * $PLU['LU'][$k][$i + $j];
              }
              
              
            }
            $inv[$j + $i][$j] = $temp1;
            $inv[$j][$i+$j] = $temp2 * $inv[$i + $j][$i + $j];  
          }        
        }
        $PLU['LU'] = $inv;
        unset($inv);
        $inv = array();
        //Now, we perform the multiplication of U_inv * L_inv
        for($i = 0; $i < $n; $i++)
        {
          for($j = 0; $j < $n; $j++)
          {
            for($k = max($j, $i); $k <= $n; $k++)
            {
              if($k == max($j, $i))
              {
                if($k == $i)
                {
                  $inv[$j][$i] = $PLU['LU'][$j][$k];            
                }
                else
                {
                  $inv[$j][$i] = $PLU['LU'][$k][$i] * $PLU['LU'][$j][$k];            
                }
                
              }
              else
              {
                if($k == $i)
                {
                  $inv[$j][$i] += $PLU['LU'][$j][$k];            
                }
                else
                {
                  $plu_a = isset($PLU['LU'][$k][$i]) ? $PLU['LU'][$k][$i] : 0;
                  $plu_b = isset($PLU['LU'][$j][$k]) ? $PLU['LU'][$j][$k] : 0;
                  $inv[$j][$i] += $plu_a*$plu_b;
                }
              }          
            }
          }
        }
        //Finally, we multiply UL_inv * P_inv to get the inverse
        $PLU['LU'] = $inv;
        unset($inv);
        $inv = array();
        for($i = 0; $i < $n; $i++)
        {
          for($j = 0; $j < $n; $j++)
          {
            for($k = 0; $k < $n; $k++)
            {
              $plu_a = isset($PLU['LU'][$i][$k]) ? $PLU['LU'][$i][$k] : 0;
              $plu_b = isset($PLU['P'][$k][$j]) ? $PLU['P'][$k][$j] : 0;              
              if($k == 0)
              {
                $inv[$i][$j] = $plu_a*$plu_b;            
              }
              else
              {
                $inv[$i][$j] += $plu_a*$plu_b;            
              }
              
            }
          }
        }
        $the_inverse = new matrix($inv);
      }
      else
      {
        echo "\n\n\n Matrix has a zero determinant !! \n\n\n";
        $the_inverse = $this->zeros(1,1);
      }
    }
    else
    {
      echo "\n\n\n Matrix is not square !! \n\n\n";
      $the_inverse = $this->zeros(1,1);
    }
    return $the_inverse;
  }
  
  /**
   * Compute each element of this matrix with each element of some matrix
   *
   * E.g. this_ij * someMatrix_ij
   *
   * Pre-requisite : both matrix must have the same size. Otherwise, an error message is echoed to the standard output.
   *
   * @param matrix $someMatrix the matrix used to perform the element by element multiplication.
   * @return The element by element product matrix OR a matrix of zeros if the pre-requisite is not met.
   */
  function p_times($someMatrix)
  {
    
    if($this->size_eq($someMatrix))
    {
      foreach($this->numbers as $i => $row)
      {
        foreach($row as $j => $number)
        {
          if(empty($someMatrix->numbers[$i][$j]) == false)
          {
            $the_point_to_point[$i][$j] = $number * $someMatrix->numbers[$i][$j];
          }
        }
      }
      $the_point_to_point_product = new matrix($the_point_to_point, $this->get_num_rows(), $this->get_num_columns());
    }
    else
    {
      echo "\n\n\n wrong dimensions in point product !! \n\n\n";
      $the_point_to_point_product = $this->zeros(1,1);
    }
    
    return $the_point_to_point_product;
  }

  /**
   * Compute element by element division
   *   
   * E.g. this_ij / someMatrix2_ij
   *
   * Pre-requisites : both matrix must have the same size and no elements of someMatrix is zero. Otherwise an error message is echoed to the standard output.
   *
   * @param matrix $someMatrix the matrix of divisors.
   * @return The element by element division matrix OR a matrix of zeros if the pre-requisites are not met.
   */
  function p_div($someMatrix)
  {
    $noZeros = false;
    foreach($someMatrix->numbers as $key => $rows)
    {
      if(count($rows) < $someMatrix->get_num_rows())
      {
        $noZeros = true;
      }
    }  
    if($this->size_eq($someMatrix) and $noZeros == false)
    {
      foreach($this->numbers as $i => $rows)
      {
        foreach($rows as $j => $numbers)
        {
          $the_point_to_point[$i][$j] = $numbers / $someMatrix->numbers[$i][$j];
        }
      }
    }
    else
    {
      echo "\n\n\n Wrong dimensions in point division and/or the matrix two has some zeros !! \n\n\n";
    }
    $the_point_to_point_division = new matrix($the_point_to_point, $someMatrix->get_num_rows(), $someMatrix->get_num_columns());
    
    return $the_point_to_point_division;
  }
  
  /**
   * Finds the max of each column of this matrix
   *
   * @return An 1 x m matrix with the maximum of each columns.
   */
  function mat_max()
  {
    $i = 0;
    $position = -1; 
    while($i < $this->get_num_rows())
    {
      if(empty($this->numbers[$i]) == false)
      {
        $position = $i;
        $i = $this->get_num_rows();
      }
      else
      {
        $i++;
      }
    }
    if($position > -1)
    {
      $max[0] = $this->numbers[$position];
      foreach($this->numbers as $i => $rows)
      {
        foreach($rows as $j => $number)
        {
          if($number > $max[0][$j])
          {
            $max[0][$j] = $number;
          }
        }
      }  
    }
    $the_max = new matrix($max, 1, $this->get_num_columns());

    return $the_max;
  }
  
  
  /**
   * Compute the min of each column of this matrix
   *
   * @return An 1 x m matrix with the minimum of each columns.
   */
  function mat_min()
  {
    $i = 0;
    $position = -1; 
    while($i < $this->get_num_rows())
    {
      if(empty($this->numbers[$i]) == false)
      {
        $position = $i;
        $i = $this->get_num_rows();
      }
      else
      {
        $i++;
      }
    }
    if($position > -1)
    {
      $min[0] = $this->numbers[$position];
      foreach($this->numbers as $i => $rows)
      {
        foreach($rows as $j => $number)
        {
          if($number < $min[0][$j])
          {
            $min[0][$j] = $number;
          }
        }
      }  
    }
    $the_min = new matrix($min, 1, $this->get_num_columns());

    return $the_min;
  }

  /**
   * Element by element greater than comparison.
   *
   * E.g. 1 if this_ij >Â someMatrix_ij and 0 otherwise. 
   *
   * Pre-requiste : both matrices must have the same dimensions. Otherwise an error message is echoed to the standart output.
   *
   * @param matrix $someMatrix
   * @return A matrix of zeros and ones OR a matrix of zeros if the pre-requisite is not met. 
   */
  function gt($someMatrix)
  {
    if($this->size_eq($someMatrix) == true)
    {
      $what_is_greater = $this->zeros($this->get_num_rows(), $this->get_num_columns());
      
      for($i = 0; $i < $this->get_num_rows(); $i++)
      {
        for($j = 0; $j < $this->get_num_columns(); $j++)
        {
          if(empty($this->numbers[$i][$j])== false)
          {
            if(empty($someMatrix->numbers[$i][$j]) == false)
            {
              if($this->numbers[$i][$j] > $someMatrix->numbers[$i][$j])
              {
                $what_is_greater->numbers[$i][$j] = 1;
              }
            }
            else
            {
              if($this->numbers[$i][$j] > 0)
              {
                $what_is_greater->numbers[$i][$j] = 1;
              }
            }
          }
          else
          {
            if(0 > $someMatrix->numbers[$i][$j])
            {
              $what_is_greater->numbers[$i][$j] = 1;
            }
          }
          
        }
      }
    }
    else
    {
      echo "Wrong dimensions in gt !!!<br><br>";
      $what_is_greater = $this->zeros(1,1);
    };
    return $what_is_greater;
  }
  
  /**
   * Element by element greater than or equal comparison.
   *
   * E.g. 1 if this_ij >=Â someMatrix_ij and 0 otherwise. 
   *
   * Pre-requiste : both matrices must have the same dimensions. Otherwise an error message is echoed to the standart output.
   *
   * @param matrix $someMatrix
   * @return A matrix of zeros and ones OR a matrix of zeros if the pre-requisite is not met. 
   */
  function gteq($someMatrix)
  {
    
    if($this->size_eq($someMatrix))
    {
      $what_is_greater = $this->zeros($this->get_num_rows(), $this->get_num_columns());
      for($i = 0; $i < $this->get_num_rows(); $i++)
      {
        for($j = 0; $j < $this->get_num_columns(); $j++)
        {
          if(empty($this->numbers[$i][$j])== false)
          {
            if(empty($someMatrix->numbers[$i][$j]) == false)
            {
              if($this->numbers[$i][$j] >= $someMatrix->numbers[$i][$j])
              {
                $what_is_greater->numbers[$i][$j] = 1;
              }
            }
            else
            {
              if($this->numbers[$i][$j] >= 0)
              {
                $what_is_greater->numbers[$i][$j] = 1;
              }
            }
          }
          else
          {
            if(0 >= $someMatrix->numbers[$i][$j])
            {
              $what_is_greater->numbers[$i][$j] = 1;
            }
          }
        }
      }
    }
    else
    {
      echo "Wrong dimensions in gteq !!!<br><br>";
      $what_is_greater = $this->zeros(1,1);
    }
    
    return $what_is_greater;
  }
  
  /**
   * Element by element less than comparison.
   *
   * E.g. 1 if this_ij <Â someMatrix_ij and 0 otherwise. 
   *
   * Pre-requiste : both matrices must have the same dimensions. Otherwise an error message is echoed to the standart output.
   *
   * @param matrix $someMatrix
   * @return A matrix of zeros and ones OR a matrix of zeros if the pre-requisite is not met. 
   */
  function lt($someMatrix)
  {
    
    if($this->size_eq($someMatrix))
    {
      $what_is_smaller = $this->ones($this->get_num_rows(), $this->get_num_columns());
      $what_is_smaller = $what_is_smaller->minus($this->gt($someMatrix));
    }
    else
    {
      echo "Wrong dimensions in lt !!!<br><br>";
      $what_is_smaller = $this->zeros(1,1);
    }
    
    return $what_is_smaller;
  }
  
  /**
   * Element by element greater than comparison.
   *
   * E.g. 1 if this_ij <=Â someMatrix_ij and 0 otherwise. 
   *
   * Pre-requiste : both matrices must have the same dimensions. Otherwise an error message is echoed to the standart output.
   *
   * @param matrix $someMatrix
   * @return A matrix of zeros and ones OR a matrix of zeros if the pre-requisite is not met. 
   */
  function lteq($someMatrix)
  {
    
    if($this->size_eq($someMatrix))
    {
      $what_is_smaller = $this->ones($this->get_num_rows(), $this->get_num_columns());
      $what_is_smaller = $what_is_smaller->minus($this->gteq($someMatrix));
    }
    else
    {
      echo "Wrong dimensions in lteq !!!<br><br>";
      $what_is_smaller = $this->zeros(1,1);
    }
    
    return $what_is_smaller;
    return $what_is_smaller;
  }

  
  /**
   * Get the sum of each column.
   *   
   * @return An 1 x m matrix with the sum of each column.
   */
  function sum()
  {
    foreach($this->numbers as $i => $rows)
    {
      foreach($rows as $j => $number)
      {
        $sum[0][$j] += $number;
      }
    }
    $the_sum = new matrix($sum, 1, $this->get_num_columns());
    
    return $the_sum;
  }
  
  /**
   *   Compute the mean of each column. 
   *
   *  @return An 1 x m matrix with the mean of each column.
   */
  function mean()
  {
    $the_mean = $this->sum();
    
    $columns = $the_mean->get_num_columns();
    foreach($the_mean->numbers[0] as $j => $number)
    {
      $the_mean->numbers[0][$j] = $number / $columns;
    }

    return $the_mean;
  }
  
  
  /**
   *   Performs a PLU decomposition of this matrix.
   *   
   *   Pre-requisite : this matrix must be square. Otherwise an error message is echoed to the standard output.
   *
   *  This function sets two arrays containing the data for matrices : "P" "L", "U".
   *
   *  @return : The array $PLU which consists of $PLU['P_det'], $PLU['P'], $PLU['LU']. 
   *
   *  Example : if the matrix is : 2    1    1
   *                 1    2    1
   *                 1    1    2
   *
   *  The decomposition is then : 
   *
   *  L                1    0    0
   *                 1/2  1    0
   *                 1/2  4/3  1
   *
   *  U                2    1    1
   *                 0    3/2  1/2
   *                 0    0    4/3
   *
   *  P (determinant = 1)       1    0    0 
   *                 0    1    0
   *                 0    0    1
   *
   *
   *  So the return arrays will be : 
   *   $PLU['P']            1    0    0 
   *                 0    1    0
   *                 0    0    1
   *
   *  $PLU['P_det']  : 1
   *
   *  And the we omit the ones in the L matrix to get a "stacked" array with LU : 
   *
   *  $PLU['LU'] together :    2    1    1
   *                1/2  3/2  1/2
   *                1/2  4/3  1              
   *
   */
  private function PLU()
  {
     if($this->is_square())
    {
      $PLU['LU'] = $this->numbers;
      $PLU['P'] = array();
      // Set the permutation matrix. 
      $PLU['P_set'] = 1;
      for($k = 0; $k < $this->get_num_rows(); $k++)
      {
        $PLU['P'][$k][$k] = 1; 
      }
    
      //For all rows of the matrix....
      for($k = 0; $k < $this->get_num_rows(); $k++)
      {
          //Find the highest value of the actual column, starting at $k and switch it.
          $row = $k;
          for($j = $k; $j < $this->get_num_rows(); $j++)
          {
            if($PLU['LU'][$j][$k] > $PLU['LU'][$row][$k])
            {
              $row = $j;
            }  
          }
          
          if($row != $k) //If they are not equal, we have to switch rows
          {
            //Row switching on L
            $temp = $PLU['LU'][$k];
            $PLU['LU'][$k] = $PLU['LU'][$row];
            $PLU['LU'][$row] = $temp;
                        
            //Row switching on P
            $temp = $PLU['P'][$k];
            $PLU['P'][$k] = $PLU['P'][$row];
            $PLU['P'][$row] = $temp;
            $PLU['P_set'] *= -1;
          }
          
          //Then, we perform the algorithm on L 
          //(note : you gotta admire this. Such a small piece of code for a so powerful result)
          
          //For all the values in the column $k
          for($i = $k+1; $i < $this->get_num_rows(); $i++)
          {  
            //If we are below the diagonal, then we work on L...
              if(empty($PLU['LU'][$i][$k]) == false and $i > $k)
              {
                $PLU['LU'][$i][$k] = $PLU['LU'][$i][$k]/$PLU['LU'][$k][$k];
              }
              
              //Now for all elements of the U matrix...
            for($j = $k+1; $j < $this->get_num_rows(); $j++)
            {
                 if(empty($PLU['LU'][$i][$j]) == false)
                   {
                     if(empty($PLU['LU'][$k][$j]) == false)
                     {
                       $PLU['LU'][$i][$j] = $PLU['LU'][$i][$j] - $PLU['LU'][$i][$k] * $PLU['LU'][$k][$j];
                     }
                   }
                   else
                   {
                     if(empty($PLU['LU'][$k][$j]) == false)
                     {
                       $PLU['LU'][$i][$j] = - $PLU['LU'][$i][$k] * $PLU['LU'][$k][$j];
                     }
                   }
              }
          }
      }  
      //P needs to be transposed
        foreach($PLU['P'] as $i => $row)
        {
          foreach($row as $j => $value)
          {
            $new_P[$j][$i] = $value; 
          }
        }
    }
    else
    {
      echo "Wrong dimensions in LU !!!<br><br>";
      $PLU['LU'] = $this->numbers;
    }
    return $PLU;
  }
  
  /**
  * Performs a PLU decomposition of this matrix.
  *   
  * Pre-requisite :this matrix must be square. Otherwise an error message is echoed to the standard output.
  *
  * @return : A 2n x n matrix where :
  *      - the first n x n matrix is the permutation matrix.
  *      - the second n x n matrix is the LU decomposition "stacked" where "ones" of the lower diagonal matrix
  *        are omitted (by convention).
  *
  *  Example : if the matrix is the 3 x 3 :   
  * 
  * 2    1    1
  *
  * 1    2    1
  *
  * 1    1    2
  *
  *  The decomposition is then : 
  *
  *  L:
  *
  * 1    0    0
  *
  * 1/2  1    0
  *
  * 1/2  4/3  1
  *
  *  U:
  *
  * 2    1    1
  *
  * 0    3/2  1/2
  *
  * 0    0    4/3
  *
  *   P:
  *
  * 1    0    0 
  *
  * 0    1    0
  *
  * 0    0    1
  *
  *
  *  So the return matrix will be : 
  *
  * 1    0    0   2    1    1
  *
  * 0    1    0   1/2  3/2  1/2
  *
  * 0    0    1   1/2  4/3  1      
  *
  */
  function lu()
  {
    $PLU = $this->PLU();
    $n = $this->get_num_rows();
    for($i = 0; $i < $n; $i++)
    {
      for($j = $n; $j < $n*2; $j++)
      {
        $PLU['P'][$i][$j] = $PLU['LU'][$i][$j - $n];
      }
    }
    $the_lu = new matrix($PLU['P']);
    return $the_lu;
  }

    
  /**
  * Prints the matrix
  *
  * Prints the matrix in an ugly table with borders in the standard output. This is intended for debugging purpose.
  */
  function print_matrix()
  {
    $numb = $this->numbers;
    echo '<table border="1">'."\n";
    for($i = 0; $i < $this->get_num_rows();$i++)
    {
      echo "<tr>";
      for($j = 0; $j < $this->get_num_columns(); $j++)
      {
        if(empty($numb[$i][$j]) == false)
        {
          echo "<td>".$numb[$i][$j]."</td>";
        }
        else
        {
          echo "<td>0</td>";
        }
        
      }
      echo "<tr>\n";
    }
    echo "</table>\n";
  }

}
?>