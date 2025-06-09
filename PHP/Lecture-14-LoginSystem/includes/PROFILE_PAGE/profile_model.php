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


function fetch_all_post_from_user(object $pdo): array {


    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM posts WHERE user_id = :user_id ORDER BY created_at DESC";
    $statement = $pdo->prepare($query);
    $statement->execute([':user_id' => $user_id]);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result ?: [];
}





