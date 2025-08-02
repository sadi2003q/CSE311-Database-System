<?php


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    
    
    try {
        $pdo = require_once "lecture-12.inc.php";
        $query = "
        INSERT INTO LOGIN_USER(username, pass, email) 
        VALUES (:username, :password, :email)                 
        ";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
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




