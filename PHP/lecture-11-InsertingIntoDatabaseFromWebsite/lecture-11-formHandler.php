<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['_inputEmail'];
    $password = $_POST['_inputPassword'];

    try {
        $pdo = require_once("lecture-11.inc.php");

        // use placeholders to prevent SQL injection
        $query = "INSERT INTO USERS(EMAIL, PWD) VALUES (:username, :password)";
        $stmt = $pdo->prepare($query);

        // bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        $stmt->execute();

        $pdo = null;
        $stmt = null;

        header("Location: lecture-11-formHandler.php");


        echo "Data inserted successfully.";

        die("Redirecting to lecture-11-formHandler.php");

    } catch (Exception $e) {
        echo "Query Failed: " . $e->getMessage();
    }
} else {
    header("Location: lecture-11-index.html");
}