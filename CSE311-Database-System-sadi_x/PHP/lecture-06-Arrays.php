<?php


$fruits = ["apple", "orange", "banana"];

$test = ["pineapple"];


echo $fruits[0] . "<br>";
echo $fruits[1] . "<br>";
echo $fruits[2] . "<br>";


//adding another element in the array
$fruits[] = 'orange';

unset($fruits[1]); // this will delete index number element and there will be no element on that index

array_splice($fruits, 1, 0, $fruits);// This inserts a full copy of the $fruits array starting at index 1, pushing existing elements forward. It does not remove any elements. This can result in duplication or a nested/shifted structure.

$task = [
    'Bard' => 'Google Gemini',
    'pig' => 'Indian',
    'inhuman' => 'Isrile'
];


print_r($task . "<br>");
echo count($task);

sort($task); //ascending order sorting(return index array)

$task["trash"] = 'Trump';

array_splice($fruits, 1, 0, "Mango"); // adding new element from index 1


array_splice($fruits, 1, 0, $test); // Adding a new array from index 1


$food = [
    ["Apple", "Banana"],
    ["Orange", "Banana"],
    ["Pineapple", "Banana"]
];


echo $food[0][1] . "<br>";


$more_food = [
    "fruits" => ["Apple", "Banana"],
    "mutton" =>  ["chicken", "beef"]
];




