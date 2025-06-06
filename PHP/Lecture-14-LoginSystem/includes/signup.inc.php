<?php
require_once "config_session.inc.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ;
    $email = $_POST['email'] ;
    $password = $_POST['password'] ;

    try {
        $pdo = require_once "dbh.inc.php";
        require_once "signup_model.inc.php";
        require_once "signup_contr.inc.php";

        // ERROR HANDLING
        $errors = [];

        // Check empty fields first
        if (is_input_empty($username, $password, $email)) {
            $errors['empty_input'] = "Please fill in all the fields";
        }
        if (is_email_valid($email)) {
            $errors['invalid_email'] = "Please enter a valid email";
        }
        if (is_username_taken($pdo, $username)) {
            $errors['username_taken'] = "Username is taken";
        }
        if (is_email_taken($pdo, $email)) {
            $errors['email_taken'] = "Email is taken";
        }

        if (!empty($errors)) {
            $_SESSION['error_signup'] = $errors;
            $_SESSION['signup_data'] = [
                'username' => $username,
                'email' => $email
            ];
            header("Location: ../HTML/login_signup.php?signup=failed");
            die('Error Found');
        }

        // If we get here, proceed with signup
        // You'll need to implement this part

        create_user($pdo, $username, $password, $email);
        header("Location: ../HTML/login_signup.php?signup=success");

        $pdo = null;

        die("Login successful");

    } catch (PDOException $e) {
        header("Location: ../HTML/loginFailed.html");
        die("Database error: " . $e->getMessage());
    }
} else {
    header("Location: ../HTML/login_signup.php");
    die();
}