<?php


if($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        // Connection with session configuration
        require_once '../config_session.inc.php';

        // Unset all session variables
        $_SESSION = [];

        // Delete the session cookie if it exists
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Destroy the session
        session_destroy();

        // Redirect to login page
        header("Location: ../../HTML/login.php?logout=success");
        exit();


    } catch (Exception $e) {
        
        // this will leads to logout error 
        $error_logout['logout_error'] = 'Something went wrong while logging out';
        $_SESSION['error_logout'] = $error_logout;

        header("Location: ../../HTML/logging.php?logout=error");

        die("Error Occurred");
    }




} else {
    header("Location: ../../HTML/newsfeed.php?logout=error");
    die("Error Occurred");
}


