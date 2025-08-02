<?php

declare(strict_types=1);



function fetch_the_post(object $pdo, int $postID) {
    
    $query = "SELECT * FROM posts where post_id = :post_id";
    $statement = $pdo->prepare($query);
    // $statement->execute(); 
    $statement->execute([':post_id' => $postID]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result ?: [];
}



function fetch_post_maker_information(object $pdo, int $user_id) {
    $query = "SELECT * FROM users where user_id = :user_id";
    $statement = $pdo->prepare($query);
    // $statement->execute(); 
    $statement->execute([':user_id' => $user_id]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result ?: [];
}


function check_if_liked_or_not(object $pdo, int $postID, int $postLikerID): bool {
    try {
        // Require the database handler.
        

        // SQL query to find a like from the user on the specific post.
        $query = "SELECT * FROM LIKES WHERE user_id = :postLikerID AND post_ID = :postID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':postLikerID', $postLikerID, PDO::PARAM_INT);
        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->execute();

        // If a row is found, it means the post is liked.
        return $stmt->rowCount() > 0;

    } catch (Exception $e) {
        // Output error message and return false on exception.
        echo 'Something went wrong: ' . $e->getMessage();
        return false; // Return false on error
    }
}