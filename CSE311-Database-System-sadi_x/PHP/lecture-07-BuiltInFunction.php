<?php
$name = 'Adnan Abdullah Sadi';
echo strlen($name); // length of the string
echo strpos($name, "S"); // position of S
echo str_replace("Adnan", "Sadi", $name); // replace adnan by sadi
echo strtolower($name); // lower case
echo strtoupper($name); // upper case

echo substr($name, 0, 5); // from 0th index to length 5 substring
echo substr($name, 0, -2);
print_r(explode(" ", $name)); // separate based on "_"(space)

$number = -5.5;
echo abs($number); // positive value
echo round(abs($number)); // nearest whole number
echo pow($number, 2); // power of 2
echo sqrt($number); // square root
echo rand(1, 100); // random number from 1 and 100


$array = [1, 2, 3, 4, 5, 6, 7, 8, 9];
echo count($array); // number of data
echo count(array_unique($array)); // count of unique value
echo array_push($array, 'kiwi'); // adding new value
array_pop($array);  // removing the last index element
print_r(array_reverse($array)); // reverse order printing


echo date('Y-m-d H:i:s'); // this will print the date  and time
echo time();



