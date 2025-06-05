<?php

declare(strict_types=1);

function get_username(object $pdo, string $username) {
    $query = "SELECT USERNAME FROM LOGIN_USER WHERE username = :username";
    $statement = $pdo->prepare($query);
    $statement->execute([':username' => $username]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function get_email(object $pdo, string $email) {
    $query = "SELECT EMAIL FROM LOGIN_USER WHERE email = :email";
    $statement = $pdo->prepare($query);
    $statement->execute([':email' => $email]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}


function set_user(object $pdo, string $username, string $password, string $email): void {
    $query = "INSERT INTO LOGIN_USER (username, password, email) VALUES (:username, :password, :email)";
    $statement = $pdo->prepare($query);

    $option = [
        'cost' => 12,
    ];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT, $option);


    $statement->execute([':username' => $username, ':password' => $hashed_password, ':email' => $email]);


}





























