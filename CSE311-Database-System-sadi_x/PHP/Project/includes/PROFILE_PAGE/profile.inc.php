<?php
require_once '../config_session.inc.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $gender = $_POST['sex'];

    $pdo = require_once '../dbh.inc.php';
    require_once 'profile_model.php';
    require_once 'profile_contr.php';

    $error_UpdateProfile = [];

    if(are_all_fields_empty($username, $email, $gender)) {
        $error_UpdateProfile['empty_input'] = "Please fill in all the fields";
    }
    if(is_it_similar_to_current_information($username, $email, $gender)) {
        $error_UpdateProfile['same_inputField'] = "All fields are the same as current information";
    }
    if(is_this_email_already_taken($pdo, $email)) {
        $error_UpdateProfile['email_taken'] = "Email is already taken";
    }
    if(is_this_username_already_taken($pdo, $username)) {
        $error_UpdateProfile['username_taken'] = "Username is already taken";
    }


    if(!empty($error_UpdateProfile)) {
        $_SESSION['error_UpdateProfile'] = $error_UpdateProfile;
        Header("Location: ../../HTML/profile.php?update=error");
        die('Error Updating Profile');

    }

    update_user($pdo, $username, $email, $gender);

    header("Location: ../../HTML/profile.php?update=success");

    $pdo = null;


} else {
    header("Location: ../../HTML/login.php");
    die('Something went wrong');
}


