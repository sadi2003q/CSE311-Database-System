<?php

declare(strict_types=1);

// ERROR HANDLING

function is_input_empty(string $username, string $password, string $email ): bool {
    return empty($username) || empty($password) || empty($email);
}

function is_email_valid(string $email): bool {
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
}


function is_username_taken(object $pdo, string $username): bool {
    return get_username($pdo, $username);
}

function is_email_taken(object $pdo, string $email): bool {
    return get_email($pdo, $email);
}

function create_user(object $pdo, string $username, string $password, string $email): void {
    set_user($pdo, $username, $password, $email);
}

