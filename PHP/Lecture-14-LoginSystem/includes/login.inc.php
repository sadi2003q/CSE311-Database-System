<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $pdo = require_once "dbh.inc.php";
        require_once "login_model.inc.php";
        require_once "login_contr.inc.php";
        // ERROR HANDLING
        $errors = [];

        // Check empty fields first
        if (is_input_empty($username, $password)) {
            $errors['empty_input'] = "Please fill in all the fields";
        }

        $result = get_user($pdo, $username);
        if(is_username_wrong($result)) {
            $errors['username_wrong'] = "Username is wrong";
        }
        if(!is_username_wrong($result) && is_password_wrong($password, $result['PASSWORD'])) {
            $errors['password_wrong'] = "Password is wrong";
        }


        require_once 'config_session.inc.php';

        if (!empty($errors)) {
            $_SESSION['error_login'] = $errors;

            header("Location: ../HTML/login.php?login=failed");
            die('Error Found');
        }

        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result['ID'];
        session_id($sessionId);


        $_SESSION['user_id'] = $result['ID'];
        $_SESSION['username'] = htmlspecialchars($result['USERNAME']);

        $_SESSION['last_generation'] = time();

        header("Location: ../HTML/login.php?login=success");
        $pdo = null;
        $stmt = null;

        die('Login successful');

    } catch (Exception $e) {
        header("Location: ../HTML/ServerFailed.html");
        die("Error: " . $e->getMessage());
    }

} else {
    header("Location: ../HTML/login.php");
}


