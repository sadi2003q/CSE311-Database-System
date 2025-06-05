<?php


require_once "config_session.inc.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $pdo = require_once "dbh.inc.php";
        require_once "signup_model.inc.php";
        require_once "signup_contr.inc.php";

        //ERROR HANDLING WHILE SIGNING UP
        $errors = [];

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
            header("Location: ../HTML/login_signup.php");
            die();
        }


        create_user($pdo, $username, $email, $password);
        header("Location: ../HTML/login_signup.php?signup=success");

        $pdo = null;
        $stmt = null;

        die();



    } catch (Exception $e) {
        header("Location: ../HTML/loginFailed.html");
        die('Connection failed: ' . $e->getMessage());
    }
} else {
    header("Location: ../HTML/login_signup.php");
    die();
}