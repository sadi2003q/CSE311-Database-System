<?php

declare(strict_types=1);


function update_user_database(object $pdo, string $username, string $email, string $gender, int $user_id): void {
    $query = "UPDATE USERS SET username = :username, email = :email, gender = :gender WHERE user_id = :user_id";
    $statement = $pdo->prepare($query);
    $statement->execute([':username' => $username, ':email' => $email, ':gender' => $gender, ':user_id' => $user_id]);

}




function email_exists(object $pdo, string $email): bool {
    $query = "SELECT 1 FROM USERS WHERE email = :email LIMIT 1";
    $statement = $pdo->prepare($query);
    $statement->execute([':email' => $email]);
    return (bool) $statement->fetchColumn();
}


function username_exists(object $pdo, string $username): bool {
    $query = "SELECT 1 FROM USERS WHERE username = :username LIMIT 1";
    $statement = $pdo->prepare($query);
    $statement->execute([':username' => $username]);
    return (bool) $statement->fetchColumn();
}

