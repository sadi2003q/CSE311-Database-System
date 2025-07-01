<?php 

declare(strict_types=1);
require_once '../config_session.inc.php';

if($_SERVER['REQUEST_METHOD']=='GET') {
    try {
        $pdo = require_once '../dbh.inc.php';
        $username = $_GET['username'] ?? '';
        $email = $_GET['email'] ?? '';
        $password = $_GET['password'] ?? '';

        // Use or validate values
        echo "Username: " . $username;
        echo "Email: " . $email;
        echo "Password: " . $password;


        


    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
