<?php

// When User submits --> Post Method
// when showing something to the user --> Get method

// referencing tag by 'name'


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = htmlspecialchars($_POST['firstName']);// never trust what user provides
    $lastName = htmlspecialchars($_POST['lastName']);
    $favouritePet = htmlspecialchars($_POST['favouritePet']);

    if(empty($firstName) || empty($lastName) || empty($favouritePet)) {
        exit("All fields are required");
    }

    echo "<br> these are the data that user submitted {$firstName} {$lastName} and  {$favouritePet}";


}
header("Location: lecture-03-FormHandling_index.php");

























