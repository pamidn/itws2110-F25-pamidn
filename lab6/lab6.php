<?php 

abstract class Operation {
  protected $operand_1;
  protected $operand_2;
  public function __construct($o1, $o2) {
    // Make sure we're working with numbers...
    if (!is_numeric($o1) || !is_numeric($o2)) {
      throw new Exception('Non-numeric operand.');
    }
    
    // Assign passed values to member variables
    $this->operand_1 = $o1;
    $this->operand_2 = $o2;
  }
  public abstract function operate();
  public abstract function getEquation(); 
}

// Addition subclass inherits from Operation
class Addition extends Operation {
  public function operate() {
    return $this->operand_1 + $this->operand_2;
  }
  public function getEquation() {
    return $this->operand_1 . ' + ' . $this->operand_2 . ' = ' . $this->operate();
  }
}


// Part 1 - Add subclasses for Subtraction, Multiplication and Division here
class Subtraction extends Operation {
  public function operate() {
    return $this->operand_1 - $this->operand_2;
  }
  public function getEquation() {
    return $this->operand_1 . ' - ' . $this->operand_2 . ' = ' . $this->operate();
  }
}

class Multiplication extends Operation {
  public function operate() {
    return $this->operand_1 * $this->operand_2;
  }
  public function getEquation() {
    return $this->operand_1 . ' * ' . $this->operand_2 . ' = ' . $this->operate();
  }
}

class Division extends Operation {
  public function operate() {
    if ($this->operand_2 == 0) {
      throw new Exception('Division by zero is not allowed.');
    }
    return $this->operand_1 / $this->operand_2;
  }
  public function getEquation() {
    return $this->operand_1 . ' / ' . $this->operand_2 . ' = ' . $this->operate();
  }
}



// End Part 1




// Some debugs - un comment them to see what is happening...
// echo '$_POST print_r=>',print_r($_POST);
// echo "<br>",'$_POST vardump=>',var_dump($_POST);
// echo '<br/>$_POST is ', (isset($_POST) ? 'set' : 'NOT set'), "<br/>";
// echo "<br/>---";




// Check to make sure that POST was received 
// upon initial load, the page will be sent back via the initial GET at which time
// the $_POST array will not have values - trying to access it will give undefined message

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $o1 = $_POST['op1'];
    $o2 = $_POST['op2'];
  }
  $err = Array();


// Part 2 - Instantiate an object for each operation based on the values returned on the form
//          For example, check to make sure that $_POST is set and then check its value and 
//          instantiate its object
// 
// The Add is done below.  Go ahead and finish the remiannig functions.  
// Then tell me if there is a way to do this without the ifs:

// Yes, there is a way to do this without using multiple if statements. We can use an associative array to map each button name to its corresponding class.
// Then, by looping through the array, we can check which button was pressed and dynamically create the correct operation object. 


  try {
    if (isset($_POST['add']) && $_POST['add'] == 'Add') {
      $op = new Addition($o1, $o2);
    }
// Put the code for Part 2 here  \/


    else if (isset($_POST['sub']) && $_POST['sub'] == 'Subtract') {
      $op = new Subtraction($o1, $o2);
    }
    else if (isset($_POST['mult']) && $_POST['mult'] == 'Multiply') {
      $op = new Multiplication($o1, $o2);
    }
    else if (isset($_POST['div']) && $_POST['div'] == 'Divide') {
      $op = new Division($o1, $o2);
    }



// End of Part 2   /\

  }
  catch (Exception $e) {
    $err[] = $e->getMessage();
  }
?>

<!doctype html>
<html>
<head>
<title>Lab 6</title>
</head>
<body>
  <pre id="result">
  <?php 
    if (isset($op)) {
      try {
        echo $op->getEquation();
      }
      catch (Exception $e) { 
        $err[] = $e->getMessage();
      }
    }
      
    foreach($err as $error) {
        echo $error . "\n";
    } 
  ?>
  </pre>
  <form method="post" action="lab6start.php">
    <input type="text" name="op1" id="name" value="" />
    <input type="text" name="op2" id="name" value="" />
    <br/>
    <!-- Only one of these will be set with their respective value at a time -->
    <input type="submit" name="add" value="Add" />  
    <input type="submit" name="sub" value="Subtract" />  
    <input type="submit" name="mult" value="Multiply" />  
    <input type="submit" name="div" value="Divide" />  
  </form>
</body>
</html>

<?php
/*
---------------------------------------
Lab 6 Questions and Answers
---------------------------------------

1) Explain what each of your classes and methods does, the order in which methods are invoked, 
   and the flow of execution after one of the operation buttons has been clicked.

   - The abstract class `Operation` defines a structure for all math operations. 
     It stores the two operands and ensures they are numeric in the constructor. 
     It also defines two abstract methods — `operate()` and `getEquation()` — which 
     are implemented differently by each subclass.

   - The subclasses `Addition`, `Subtraction`, `Multiplication`, and `Division` each 
     inherit from `Operation` and override `operate()` to perform the correct math, and 
     `getEquation()` to return a formatted string like "5 + 3 = 8".

   - When the user clicks a button, the form sends a POST request to the same page. 
     The PHP code checks which button was pressed (using `isset($_POST['add'])`, etc.) 
     and creates an object of the corresponding class. Then, `$op->getEquation()` is called 
     to display the full equation and result inside the `<pre>` block.


2) Explain how the application would differ if you were to use $_GET, 
   and why this may or may not be preferable.

   - If we used `$_GET`, the operands and button values would be sent through the URL 
     instead of the POST body (e.g. `lab6start.php?op1=4&op2=2&add=Add`). 
     This would make the results visible and shareable as a URL, but it’s less secure 
     because the data is public and limited by URL length. POST is better for form 
     submissions because it keeps data hidden from the address bar and is generally safer 
     for user input.


3) Explain whether there might be another (better or worse) way to determine 
   which button was pressed and take the appropriate action.

   - Instead of using multiple `if` statements, we could use a mapping array where 
     each button name corresponds to a class, like this:

       ```php
       $operations = [
         'add' => 'Addition',
         'sub' => 'Subtraction',
         'mult' => 'Multiplication',
         'div' => 'Division'
       ];

       foreach ($operations as $key => $class) {
         if (isset($_POST[$key])) {
           $op = new $class($o1, $o2);
         }
       }
       ```

     This approach avoids repetitive if-statements and makes it easier to add more 
     operations later.
*/
?>
