<?php



// This is the backend code for LOGIN 
// this will check for possible error and verify login process 



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Grabbing username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {

        // connections 
        $pdo = require_once "../dbh.inc.php"; // database connection
        require_once "login_model.inc.php"; // database login file connection
        require_once "login_contr.inc.php"; // Business logic file connection


        // ERROR HANDLING
        $errors = [];

        // Check empty fields first
        if (is_input_empty($username, $password)) {
            $errors['empty_input'] = "Please fill in all the fields";
        }

        // Fetching Result and Verification 
        $result = get_user($pdo, $username);
        if(is_username_wrong($result)) {
            $errors['username_wrong'] = "Username is wrong";
        }
        if(!is_username_wrong($result) && is_password_wrong($password, $result['PASSWORD'])) {
            $errors['password_wrong'] = "Password is wrong";
        }

        // Session Variable configuration file connection
        require_once '../config_session.inc.php';


        // if Error is found 
        if (!empty($errors)) {
            $_SESSION['error_login'] = $errors;

            header("Location: ../../HTML/login.php?login=failed");
            die('Error Found');
        }

        // Security Purpose
        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result['user_id'];
        session_id($sessionId);

        // Storing into session Variable
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['last_generation'] = time();

        // Login Success
        header("Location: ../../HTML/newsfeed.php?user_id=" . $result['user_id']);

        $pdo = null;
        $stmt = null;

        die('Login successful');

    } catch (Exception $e) {
        // Any exception will lead to Server Failed Page
        header("Location: ../../HTML/ServerFailed.html");
        die("Error: " . $e->getMessage());
    }

} else {
    header("Location: ../../HTML/login.php");
}


