<?php

declare(strict_types=1);

function check_signup_errors(): void {
    if(isset($_SESSION['error_signup'])) {
        $errors = $_SESSION['error_signup'];

        if (isset($_GET['signup']) and $_GET['signup'] === 'failed') {
            echo "<br>";
            echo "<p style='color: orangered; font-weight: bolder; text-decoration: underline;'>Login Failed!!!</p><br>";
        }


        foreach($errors as $error) {
            echo "<p style='font-weight: bold; color: indianred;'>" . $error . "</p> <br>";
        }

        unset($_SESSION['error_signup']);
    }
    else if (isset($_GET['signup']) and $_GET['signup'] === 'success') {
        echo "<br>";
        echo "<p style='color: darkolivegreen; font-weight: bold;'>You have successfully signed up!</p>";
    }
}