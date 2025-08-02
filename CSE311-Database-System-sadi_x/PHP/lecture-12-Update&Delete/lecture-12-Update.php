<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $newPassword = $_POST['new_password'];
    $email = $_POST['email'];


    try {
        $pdo = require_once "lecture-12.inc.php";
        $query = "
            UPDATE LOGIN_USER
            SET USERNAME = :username, PASS = :newPassword, EMAIL = :email
            WHERE USERNAME = :username AND EMAIL = :email
        ";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':newPassword', $newPassword);
        $stmt->bindParam(':email', $email);

        $stmt->execute();

        $pdo = null;
        $stmt = null;

        header("Location: lecture-12-loginSuccess.html");


    } catch (Exception $e) {
        echo $e->getMessage();
    }


} else {
    header("Location: lecture-12-loginError.html");
}




