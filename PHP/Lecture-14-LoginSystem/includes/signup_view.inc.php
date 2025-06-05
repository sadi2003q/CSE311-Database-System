<?php

declare(strict_types=1);

function check_signup_errors(): void {
    if(isset($_SESSION['error_signup'])) {
        $errors = $_SESSION['error_signup'];

        foreach($errors as $error) {
            echo "<p>" . $error . "</p> <br>";
        }

        unset($_SESSION['error_signup']);
    }else if (isset($_GET['signup']) and $_GET['signup'] === 'success') {
        echo "<br>";
        echo "<p style='color: lightgreen; font-weight: bold;'>You have successfully signed up!</p>";
    }
}