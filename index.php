<?php
   $display = "";  // Initialize the variable $num to an empty string

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Check if the request method is POST (form submitted)
      if (isset($_POST['display'])) {
         $display = $_POST['display'];  // Set $num to the value of 'input' from the form
      }
   
      if (isset($_POST['num'])) {
         $input = $_POST['num'];
         if($display == "Invalid."){
            $display = "";
         }
         // Check if 'num' is set and if it matches a valid numeric pattern
         if (preg_match('/^\d*\.?\d*$/', $input)) {
               $display .= $input;  // Append valid numeric input to $num
         } else {
               $display = "Error";  // Set $num to "Error" if input is invalid
         }
      }
   
      if (isset($_POST['op'])) {
         $op = $_POST['op'];
         // Check if 'op' is set and if it's a valid arithmetic operator (+, -, *, /, %)
         if (preg_match('/[\+\-\*\/%]/', $op)) {
               $display .= $op;  // Append valid operator to $num
         } else {
               $display = "Error";  // Set $num to "Error" if operator is invalid
         }
      }
   
      if (isset($_POST['equal'])) {
         // Evaluate the expression and handle division by zero
         $result = evaluateExpression($display);
         if ($result === false) {
            $display = "Invalid.";  // Set $num to error message for division by zero
         } else {
            $display = $result;  // Set $num to the computed result
         }
      }
   
      if (isset($_POST['clear'])) {
         $display = "";  // Clear $num (reset to empty string) when 'clear' button is pressed
      }
   }
      // Function to evaluate arithmetic expression
   function evaluateExpression($expression) {
      try {
         // Use eval() to evaluate the expression and return the result
         $result = @eval("return ($expression);");

         // Check if division by zero occurred
         if ($result === false && strpos($expression, '/ 0') !== false) {
            return false;  // Return false to indicate division by zero error
         }

         return $result;  // Return the computed result of the expression
      } catch (Throwable $e) {
         return false;  // Return false if an exception (error) occurs during evaluation
      }
   }

?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Calculator</title>
      <link rel="stylesheet" href="style.css">
   </head>
   <body>
      
      <div class="calculator">
         <h2>MY CALCULATOR</h2>
         <form id="form" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" class="display" name="display" value="<?php echo htmlspecialchars($display); ?>">
            
            <div>
                  <input type="submit" class="btn" name="num" value="7">
                  <input type="submit" class="btn" name="num" value="8">
                  <input type="submit" class="btn" name="num" value="9">
                  <input type="submit" class="btn" name="op" value="+">
            </div>
            <div>
                  <input type="submit" class="btn" name="num" value="4">
                  <input type="submit" class="btn" name="num" value="5">
                  <input type="submit" class="btn" name="num" value="6">
                  <input type="submit" class="btn" name="op" value="-">
            </div>
            <div>
                  <input type="submit" class="btn" name="num" value="1">
                  <input type="submit" class="btn" name="num" value="2">
                  <input type="submit" class="btn" name="num" value="3">
                  <input type="submit" class="btn" name="op" value="*">
            </div>
            <div>
                  <input type="submit" class="btn" name="num" value="0">
                  <input type="submit" class="btn" name="num" value=".">
                  <input type="submit" class="btn clear" name="clear" value="C">
                  <input type="submit" class="btn" name="op" value="/">
                  
            </div>
            <div>
               <input type="submit" class="equal" name="equal" value="=">
            </div>
         </form>
      </div>
   </body>
</html>