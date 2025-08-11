<?php

declare(strict_types=1);


// Fetches a post from the database using the post ID.
function fetch_the_post(object $pdo, int $postID) {
    
    $query = "SELECT * FROM posts where post_id = :post_id";
    $statement = $pdo->prepare($query);
    // $statement->execute(); 
    $statement->execute([':post_id' => $postID]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result ?: [];
}


// Fetches information about the user who made a post.
function fetch_post_maker_information(object $pdo, int $user_id) {
    $query = "SELECT * FROM users where user_id = :user_id";
    $statement = $pdo->prepare($query);
    // $statement->execute(); 
    $statement->execute([':user_id' => $user_id]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result ?: [];
}

// Checks if a user has already liked a specific post.
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

// Adds a new comment to a post.
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
    Increment_commnt_count($pdo, (int)$postID);
    
    $postMakerID = fetch_Post_Maker_ID($pdo, $postID);
    
    
    if((int)$user_id != (int)$postMakerID) {
        comment_notification($pdo, (int)$user_id, (int)$postMakerID, (int)$postID);
    }
    

}
// Increments the comment count for a post.
function Increment_commnt_count(object $pdo, int $postID) {
    $query = 'UPDATE POSTS SET COMMENT_COUNT = COMMENT_COUNT + 1 WHERE POST_ID = :postID';
    $statement = $pdo->prepare($query);
    $statement->bindValue(':postID', $postID, PDO::PARAM_INT);
    if (!$statement->execute()) {
        throw new Exception("Failed to increment comment count");
    }
}

// Fetches all comments for a given post.
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


// Finds the total number of likes for a post (retrieved from the session).
function find_the_number_of_like(object $pdo) {

    $postID = $_SESSION['working_on_post'];

    $query = "SELECT COUNT(post_id) FROM likes WHERE POST_ID=:postID";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':postID', $postID, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchColumn();
    return $result ? (int)$result : 0;

}


// Fetches the total number of comments for a post (retrieved from the session).
function fetch_the_number_of_comment(object $pdo) {
    $postID = $_SESSION['working_on_post'];
    $query = "SELECT COUNT(post_id) from COMMENTS where post_id=:postID";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':postID', $postID, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchColumn();
    return $result ? (int)$result : 0;
}

// Deletes a specific comment from the database.
function delete_comment(object $pdo, int $comment_number) {
    $query = "DELETE FROM comments WHERE comment_id = :comment_id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':comment_id', $comment_number, PDO::PARAM_INT);
    $statement->execute();

}

// Updates the text of an existing comment.
function update_comment(object $pdo, int $commentID, string $newText): void {
    $query = "UPDATE comments SET comment_text = :newText WHERE comment_id = :commentID";
    $statement = $pdo->prepare($query);

    $statement->bindValue(':newText', $newText, PDO::PARAM_STR);
    $statement->bindValue(':commentID', $commentID, PDO::PARAM_INT);

    if (!$statement->execute()) {
        throw new Exception("Failed to update comment");
    }
}


// Fetches the ID of the user who created a specific post.
function fetch_Post_Maker_ID(object $pdo, int $postID) {
    $query = "SELECT USER_ID FROM POSTS WHERE POST_ID=:postID";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':postID', $postID, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchColumn();
    return $result ? (int)$result : -1;

}

// Creates a notification when a user comments on a post.
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