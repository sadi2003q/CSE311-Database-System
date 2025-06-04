<?php

// Loops is to execute a piece of code for multiple time

// For loop
for($i=0; $i<10; $i++) {
    print("position ". ($i+1) . "\n");
}



// while loop
$i = 0;
while($i < 20) {
    print("position ". ($i+1) . "\n"); 
    $i++;
}

$fruits = ["Apple", "Banana", "Cucumbure", "dumpling"];
for($i=0; $i<count($fruits); $i++) {
    print("Fruit ". ($i+1) . ": " . $fruits[$i] . "\n");
}

foreach($fruits as $index => $fruit) {
    print("Fruit ". ($index+1) . ": " . $fruit . "\n");
}





