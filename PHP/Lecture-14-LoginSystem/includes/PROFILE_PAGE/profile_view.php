<?php


declare(strict_types=1);


use JetBrains\PhpStorm\NoReturn;

#[NoReturn] function show_user_information_profile_view(): void {

    if(isset($_SESSION['user_id']) and isset($_SESSION['username']) and isset($_SESSION['email']) and isset($_SESSION['gender'])) {

        $username = $_SESSION['username'];
        $email = $_SESSION['email'];
        $gender = $_SESSION['gender'];

        echo '<h1>Name : ' . $username . '</h1> <br>';

        echo '<p>Email : '. $email . '|'. 'Gender: ' .$gender .'</p> <br>';

    } else {
        header("location: ../../HTML/login.php?server=failed?function=profile_contr/show_user_information");
        die('Something went wrong');
    }

}


function show_username_field_profile_view(): void {
    $username = $_SESSION['username'] ?? 'No Username Found';
    echo '<input type="text" name="username" placeholder="Username" value="' . htmlspecialchars($username) . '">';
}


function show_email_field_profile_view(): void {
    $email = $_SESSION['email'] ?? 'No Email Found';
    echo '<input type="text" name="email" placeholder="Email" value="' . htmlspecialchars($email) . '">';
}

function error_found_while_updating_profile(): void {
    if (!isset($_SESSION['error_UpdateProfile']) || empty($_SESSION['error_UpdateProfile'])) {
        return; // No error to display
    }

    $errors = $_SESSION['error_UpdateProfile'];

    echo '<div style="width: 90%; padding: 5px; margin: 10px; background-color: pink; border-radius: 5px">';
    echo '<h3 style="color: orangered; font-family: \'Times New Roman\', Times, serif">Error Occurred</h3>';
    echo '<div style="margin-top: 10px;">';

    foreach ($errors as $error) {
        echo '<p>' . htmlspecialchars($error) . '</p>';
    }

    echo '</div>';
    echo '</div>';

    // Optionally clear the errors after displaying
    $_SESSION['error_UpdateProfile'] = null;
}


