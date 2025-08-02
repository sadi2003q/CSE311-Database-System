<?php
// lecture-11.inc.php
$dbName = "FACEBOOK";
$dbUsername = "root";
$dbPassword = "";

try {
    $pdo = new PDO("mysql:host=localhost;dbname=$dbName", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
    // Return the PDO object
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage()); // Use die() to stop execution on failure
}