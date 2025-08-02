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

        $query = "SELECT * FROM LIKES WHERE user_id = :postLikerID AND post_ID = :postID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':postLikerID', $postLikerID, PDO::PARAM_INT);
        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;

    } catch (Exception $e) {
        echo 'Something went wrong: ' . $e->getMessage();
        return false; 
    }
}


function post_the_comment(object $pdo, int $postID, string $comment_text) : void {
    

    $user_id = $_SESSION['user_id'];
    print('here');
    // $query = "INSERT INTO COMMENTS (user_id, post_id, created_at)
    //         VALUES (:user_id, :post_id, :comment_text )";
    // $statement = $pdo->prepare($query);
    // $statement->bindParam(':postID', $postID);
    // $statement->bindParam(':commenterID', $user_id);
    // $statement->bindParam(':comment_text', $comment_text);
    
    // $statement->execute();


}