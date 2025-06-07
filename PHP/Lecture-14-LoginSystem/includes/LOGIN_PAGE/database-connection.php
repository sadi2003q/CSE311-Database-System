<?php

$dbName = "SOCIAL_MEDIA";
$dbUsername = "root";
$dbPassword = "";
$dbHost = "localhost";


try {
    return new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}




