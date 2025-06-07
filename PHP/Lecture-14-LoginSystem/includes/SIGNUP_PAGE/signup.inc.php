<?php
require_once "../config_session.inc.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ;
    $email = $_POST['email'] ;
    $password = $_POST['password'] ;
    $dob = $_POST['dob'] ;
    $gender = $_POST['gender'] ;

    try {
        $pdo = require_once "../dbh.inc.php";
        require_once "signup_model.inc.php";
        require_once "signup_contr.inc.php";

        // ERROR HANDLING
        $errors = [];

        // Check empty fields first
        if (is_input_empty($username, $password, $email, $gender, $dob)){
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
        if (!is_age_valid($dob)) {
            $errors['age_invalid'] = "You must be at least 10 years old";
        }

        if ($errors) {
            $_SESSION['error_signup'] = $errors;

            $signup_data = [
                'username' => $username,
                'email' => $email,
                'gender' => $gender,
                'dob' => $dob,
            ];
            $_SESSION['signup_data'] = $signup_data;

            header("Location: ../../HTML/login_signup.php?signup=failed");
            die('Error Found');
        }

        // If we get here, proceed with signup
        // You'll need to implement this part

        create_user($pdo, $username, $password, $email, $gender, $dob);
        header("Location: ../../HTML/login_signup.php?signup=success");

        $pdo = null;

        die("Login successful");

    } catch (PDOException $e) {
        header("Location: ../../HTML/loginFailed.html");
        error_log("Errors found: " . print_r($e, true));
        die("Database error: " . $e->getMessage());
    }
} else {
    header("Location: ../../HTML/login_signup.php");
    die();
}