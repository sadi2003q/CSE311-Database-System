<?php


$fruits = ["apple", "orange", "banana"];

echo $fruits[0] . "<br>";
echo $fruits[1] . "<br>";
echo $fruits[2] . "<br>";


//adding another element in the array
$fruits[] = 'orange';

unset($fruits[1]); // this will delete index number element and there will be no element on that index

array_splice($fruits, 1, 0, $fruits);
