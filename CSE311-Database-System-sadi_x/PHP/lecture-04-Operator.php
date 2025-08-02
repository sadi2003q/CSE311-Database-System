<?php

$num_1 = 5;
$num_2 = 2;

echo $num_1 + $num_2;
echo $num_1 - $num_2;
echo $num_1 / $num_2;
echo $num_1 * $num_2;
echo $num_1 % $num_2;

echo $num_1 ** $num_2;  // power


if($num_1 == $num_2){
    echo "This statement is true";
}


$variable=1;
$result = match($variable) {
    1 => "The value is one",
    2 => "The value is two",
    4, 5, 6 => "The value is four or more",
    default => "None of the value match"
};

