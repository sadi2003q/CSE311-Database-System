<?php

declare(strict_types=1);

function is_username_wrong(bool | array $result): bool {
    return !($result);
}


function is_password_wrong(string $password, string $hashed_password): bool {
    if(!password_verify($password, $hashed_password)) {
        return true;
    }
    return false;
}


function is_input_empty(string $username, string $password): bool {
    return empty($username) || empty($password);
}




