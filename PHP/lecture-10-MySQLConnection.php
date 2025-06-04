<?php


$dbname = 'facebook';
$dbUserName = 'root';
$dbPassword = 'root';


try {



    $pdo = new PDO("mysql:host=localhost;dbname=$dbname", $dbUserName, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);






} catch (PDOException $e) {
    echo "something went wrong: " . $e->getMessage();
}







