<?php

declare(strict_types=1);

// ERROR HANDLING
// check if function is empty or not
function is_input_empty(string $username, string $password, string $email, string $gender, string $dob): bool {
    return empty($username) || empty($password) || empty($email) || empty($gender) || empty($dob);
}

// Check if it is a valid email
function is_email_valid(string $email): bool {
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Check if age is over 10 or not
function is_age_valid(string $dob): bool {
    $birthDate = new DateTime($dob);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate)->y;

    return $age > 10;
}

// Check if username is already taken or not
function is_username_taken(object $pdo, string $username): bool {
    return (bool) get_username($pdo, $username);
}

// check if email is taken or not
function is_email_taken(object $pdo, string $email): bool {
    return (bool) get_email($pdo, $email);
}

// set the user into the database 
function create_user(object $pdo, string $username, string $password, string $email,  string $gender, string $dob): void {
    set_user($pdo, $username, $password, $email, $gender, $dob);
}


