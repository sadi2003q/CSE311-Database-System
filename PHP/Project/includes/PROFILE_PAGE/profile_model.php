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


function check_if_liked_or_not(object $pdo, int $postID, int $postLikerID) {
    // SQL query to find a like from the user on the specific post.
    $query = "SELECT * FROM LIKES WHERE user_id = :postLikerID AND post_ID = :postID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':postLikerID', $postLikerID, PDO::PARAM_INT);
    $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
    $stmt->execute();

    // If a row is found, it means the post is liked.
    return $stmt->rowCount() > 0;
}


function delete_the_post(object $pdo, int $postID) {
    $query = "DELETE FROM POSTS WHERE POST_ID = :postID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
    $stmt->execute();

    delete_all_like_from_database($pdo, (int)$postID);
    delete_all_comments_from_database($pdo, (int)$postID);
    delete_all_notification_from_database($pdo, (int)$postID);
}

function delete_all_like_from_database(object $pdo, int $postID) {
    $query = "DELETE FROM LIKES WHERE POST_ID = :postID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
    $stmt->execute();
}


function delete_all_comments_from_database(object $pdo, int $postID) {
    $query = "DELETE FROM COMMENTS WHERE POST_ID = :postID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
    $stmt->execute();
}

function delete_all_notification_from_database(object $pdo, int $postID) {
    $query = "DELETE FROM NOTIFICATIONS WHERE POST_ID = :postID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
    $stmt->execute();
}