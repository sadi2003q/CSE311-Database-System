<?php


declare(strict_types=1);

function upload_post_to_database(object $pdo, string $post_text, string $post_image, int $user_id): void {
    $query = "INSERT INTO POSTS (user_id, text_content, image_url) 
              VALUES (:user_id, :post_text, :post_image)";

    $statement = $pdo->prepare($query);
    $statement->execute([
        ':user_id' => $user_id,
        ':post_text' => $post_text,
        ':post_image' => $post_image
    ]);
}

