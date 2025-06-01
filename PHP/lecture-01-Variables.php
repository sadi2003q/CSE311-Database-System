<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    
<!--Variable and Datatype-->

    <h1>This Lecture is Design for Variable in PHP</h1>
    <?php
        // Variable declaration and string data type
        $name = "Adnan Abdullah Sadi";
        
        // Echo the name variable
        echo $name;
        
        // Additional PHP code for the lecture
        echo "<h2>Understanding Variables in PHP</h2>";
        echo "<p>Variables in PHP are used to store data, such as numbers, text, or arrays. They start with a $ sign followed by the variable name.</p>";
        
        // Integer data type
        $age = 25;
        echo "<p>My age is: $age (Integer)</p>";
        
        // Float data type
        $height = 5.9;
        echo "<p>My height is: $height feet (Float)</p>";
        
        // Boolean data type
        $isStudent = true;
        echo "<p>Is student? " . ($isStudent ? 'Yes' : 'No') . " (Boolean)</p>";
        
        // Array data type
        $hobbies = array("Reading", "Coding", "Gaming");
        echo "<p>My hobbies are: " . implode(", ", $hobbies) . " (Array)</p>";
        
        // Null data type
        $noValue = null;
        echo "<p>No value variable: " . (is_null($noValue) ? 'Null' : $noValue) . " (Null)</p>";
        
        // Variable variables
        $varName = "dynamic";
        $$varName = "This is a dynamic variable";
        echo "<p>Dynamic variable value: $dynamic (Variable Variable)</p>";
        
        // Basic variable operations
        $num1 = 10;
        $num2 = 5;
        $sum = $num1 + $num2;
        echo "<p>Sum of $num1 and $num2 is: $sum (Basic Operation)</p>";
        
        
        //Array in PHP
    
        $studentID = [22, 13, 223, 14];


        $object = null


        //Tips
        /*
         * Make sure to assign a default value to about error
         */
    
    ?>




</body>
</html>