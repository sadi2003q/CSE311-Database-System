<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $pdo = require_once "../dbh.inc.php"; // database connection
        require_once "admin_model.inc.php";
        
        // ERROR HANDLING
        $errors = [];

        // Check empty fields
        if (empty($username) || empty($password)) {
            $errors['empty_input'] = "Please fill in all fields";
        }

        // Get admin from database
        $admin = get_admin($pdo, $username);
        
        if (!$admin) {
            $errors['login_incorrect'] = "Invalid login credentials";
        } else {
            // Verify password
            $hashedPassword = $admin['password'];
            if (!password_verify($password, $hashedPassword)) {
                $errors['login_incorrect'] = "Invalid login credentials";
            }
        }

        require_once '../config_session.inc.php';

        if (!empty($errors)) {
            $_SESSION['admin_login_errors'] = $errors;
            header("Location: ../../HTML/admin_login.php");
            die();
        }

        // Create new session ID for security
        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $admin['id'];
        session_id($sessionId);

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = htmlspecialchars($admin['username']);
        $_SESSION['admin_last_login'] = time();

        header("Location: ../../HTML/admin_dashboard.php");
        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../../HTML/admin_login.php");
    die();
}