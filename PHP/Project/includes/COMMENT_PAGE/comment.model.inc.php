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


function post_the_comment(object $pdo, int $postID, string $comment_text): void {
    require_once '../config_session.inc.php';

    if (!isset($_SESSION['user_id'])) {
        throw new Exception("User not logged in.");
    }

    $user_id = $_SESSION['user_id'];


    $query = "INSERT INTO comments (user_id, post_id, comment_text, created_at)
              VALUES (:user_id, :post_id, :comment_text, NOW())";
    
    $statement = $pdo->prepare($query);

    $statement->bindValue(':user_id', (int)$user_id, PDO::PARAM_INT);
    $statement->bindValue(':post_id', $postID, PDO::PARAM_INT);
    $statement->bindValue(':comment_text', $comment_text, PDO::PARAM_STR);

    if (!$statement->execute()) {
        throw new Exception("Failed to post comment");
    }
    
    $postMakerID = fetch_Post_Maker_ID($pdo, $postID);
    comment_notification($pdo, (int)$user_id, (int)$postMakerID, (int)$postID);

}




function fetch_all_comment(object $pdo, $postID): array {
    $query = "SELECT * FROM comments WHERE post_id = :postID ORDER BY created_at DESC";
    $statement = $pdo->prepare($query);
    
    $statement->bindValue(':postID', $postID, PDO::PARAM_INT);
    
    if ($statement->execute()) {
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return []; 
    }
}



function find_the_number_of_like(object $pdo) {

    $postID = $_SESSION['working_on_post'];

    $query = "SELECT COUNT(post_id) FROM likes WHERE POST_ID=:postID";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':postID', $postID, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchColumn();
    return $result ? (int)$result : 0;

}



function fetch_the_number_of_comment(object $pdo) {
    $postID = $_SESSION['working_on_post'];
    $query = "SELECT COUNT(post_id) from COMMENTS where post_id=:postID";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':postID', $postID, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchColumn();
    return $result ? (int)$result : 0;
}


function delete_comment(object $pdo, int $comment_number) {
    $query = "DELETE FROM comments WHERE comment_id = :comment_id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':comment_id', $comment_number, PDO::PARAM_INT);
    $statement->execute();

}


function update_comment(object $pdo, int $commentID, string $newText): void {
    $query = "UPDATE comments SET comment_text = :newText WHERE comment_id = :commentID";
    $statement = $pdo->prepare($query);

    $statement->bindValue(':newText', $newText, PDO::PARAM_STR);
    $statement->bindValue(':commentID', $commentID, PDO::PARAM_INT);

    if (!$statement->execute()) {
        throw new Exception("Failed to update comment");
    }
}



function fetch_Post_Maker_ID(object $pdo, int $postID) {
    $query = "SELECT USER_ID FROM POSTS WHERE POST_ID=:postID";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':postID', $postID, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchColumn();
    return $result ? (int)$result : -1;

}


function comment_notification(object $pdo, int $senderID, int $recipientID, int $postID) {
    try {
        
        // Corrected SQL with proper commas and column names
        $query = "INSERT INTO notifications (recipient_id, sender_id, post_id, status) 
                 VALUES (:recipient_id, :sender_id, :post_id, 'commented')";
        
        $stmt = $pdo->prepare($query);
        return $stmt->execute([
            ':recipient_id' => $recipientID,
            ':sender_id' => $senderID,
            ':post_id' => $postID
        ]);
        
    } catch (PDOException $e) {
        error_log("Like notification failed: " . $e->getMessage());
        return false;
    }
}