<?php


// this is the syntax for making a function
function sayHello(): void {
    echo "Hello World!";
}

sayHello();


function EvenOdd(int $number = 10): int {
    return $number % 2==0;
}

$flag = EvenOdd(2);
echo $flag;


function Hello(string $name = 'Adnan'): void {
    echo $name . " World!";
}
Hello();