<?php


declare(strict_types=1);

require_once 'profile_model.php';

function are_all_fields_empty(string $username, string $email, string $gender): bool {
    return empty($username) || empty($email) || empty($gender);
}


function is_it_similar_to_current_information(string $username, string $email, string $gender): bool {
    return ($username === $_SESSION['username']) && ($email === $_SESSION['email']) && ($gender === $_SESSION['gender']);
}

function is_this_email_already_taken(object $pdo, string $email): bool {
    return email_exists($pdo, $email);
}

function is_this_username_already_taken(object $pdo, string $username): bool {
    return username_exists($pdo, $username);
}




function update_user(object $pdo, string $username, string $email, string $gender): void {

    if(!isset($_SESSION['user_id'])){
        header("Location: ../../HTML/login.php?user_id=not_set");
    }

    $user_id = $_SESSION['user_id'];

    update_user_database($pdo, $username, $email, $gender, $user_id);

    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['gender'] = $gender;


}








