<?php

declare(strict_types=1);

// Error Functions


// Check if username is wrong
function is_username_wrong(bool | array $result): bool {
    return !($result);
}

// Check if password is wrong
function is_password_wrong(string $password, string $hashed_password): bool {
    if(!password_verify($password, $hashed_password)) {
        return true;
    }
    return false;
}

// Check if input is empty
function is_input_empty(string $username, string $password): bool {
    return empty($username) || empty($password);
}




