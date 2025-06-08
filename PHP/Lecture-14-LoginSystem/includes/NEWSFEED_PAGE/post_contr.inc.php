<?php


declare(strict_types=1);



function is_all_post_fields_are_empty($post_text, $post_image): bool {
    return empty($post_text) && empty($post_image);
}

function post_now(object $pdo, string $post_text, string $post_image, int $user_id): void {

    upload_post_to_database($pdo, $post_text, $post_image, $user_id);


}
