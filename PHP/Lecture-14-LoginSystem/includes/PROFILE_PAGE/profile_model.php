<?php

declare(strict_types=1);


function update_user_database(object $pdo, string $username, string $email, string $gender, int $user_id): void {
    $query = "UPDATE USERS SET username = :username, email = :email, gender = :gender WHERE user_id = :user_id";
    $statement = $pdo->prepare($query);
    $statement->execute([':username' => $username, ':email' => $email, ':gender' => $gender, ':user_id' => $user_id]);

}




