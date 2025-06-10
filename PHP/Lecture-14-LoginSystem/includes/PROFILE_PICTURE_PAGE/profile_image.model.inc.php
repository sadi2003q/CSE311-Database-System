<?php

declare(strict_types=1);



function upload_image_to_database(object $pdo, string $image_url): void {

    $user_id = $_SESSION['user_id'];

    $query = "UPDATE USERS SET image_url = :image_url WHERE user_id = :user_id";
    $statement = $pdo->prepare($query);
    $statement->execute([
        ':image_url' => $image_url,
        ':user_id' => $user_id
    ]);
}