<?php

declare(strict_types=1);

// ERROR HANDLING

function is_input_empty(string $username, string $password, string $email, string $gender, string $dob): bool {
    return empty($username) || empty($password) || empty($email) || empty($gender) || empty($dob);
}

function is_email_valid(string $email): bool {
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
}


function is_age_valid(string $dob): bool {
    $birthDate = new DateTime($dob);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate)->y;

    return $age > 10;
}

function is_username_taken(object $pdo, string $username): bool {
    return (bool) get_username($pdo, $username);
}

function is_email_taken(object $pdo, string $email): bool {
    return (bool) get_email($pdo, $email);
}

function create_user(object $pdo, string $username, string $password, string $email,  string $gender, string $dob): void {
    set_user($pdo, $username, $password, $email, $gender, $dob);
}

