<?php

declare(strict_types=1);

function check_login_status(): void {
    if(isset($_SESSION['error_login'])) {
        $errors = $_SESSION['error_login'];

        if (isset($_GET['login']) and $_GET['login'] === 'failed') {
            echo "<br>";
            echo "<p style='color: orangered; font-weight: bolder; text-decoration: underline;'>Login Failed!!!</p><br>";
        }


        foreach($errors as $error) {
            echo "<p style='font-weight: bold; color: indianred;'>" . $error . "</p> <br>";
        }


        unset($_SESSION['error_login']);

    } else if (isset($_GET['login']) and $_GET['login'] === 'success') {
        echo "<br>";
        echo "<p style='color: darkolivegreen; font-weight: bold;'>You have successfully Logged in!</p>";
    }
}


