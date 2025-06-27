<?php
// // Loop in php


// $numbers = [1, 2, 3, 4, 5];


// echo 'Array printing' . '<br>';

// for($i=0; $i<5; $i++) {
//     print('number : '. $numbers[$i]);
//     print('<br>');
// }   


// $fruits = ['Apple', 'Banana', 'Chili', 'Mango'];

// // f[0] as fruit
// // f[1] as fruit
// // f[2] as fruit


// foreach ($fruits as $fruit) {
//     echo $fruit;
//     print('<br>');
// }


// while($j<10) {

//     echo $j;
//     print('<br>');

//     $j++;
// }


// Array


$numbers = [1, 2, 3, 4, 5]; // numerical array
$student = [                // student multidimentional Array

    'student_01' => [
        'name' => 'x',
        'age' => 12
    ],

    'student_02' => [
        'name' => 'y',
        'age' => 13
    ]

];


// ['key' : 'value']
 
// echo $student['student_01']['name'];


foreach($student as $st) {
    echo $st['name'];
    echo '<br>';
}



function add(int $a, int $b) {
    try {
        return $a/$b;
    } 
    
    catch (Throwable $e) {
        echo 'Something is wrong ' . $e->getMessage();
    }
}




echo add(2, 0);



// Session
// Get Post
// PDO connection






































