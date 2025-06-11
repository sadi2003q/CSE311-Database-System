<?php


declare(strict_types=1);



function fetch_all_post_of_this_user(object $pdo, int $user_id) {
    $stmt = $pdo->prepare('SELECT * FROM posts WHERE user_id = :user_id ORDER BY created_at DESC');
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetch_email_and_gender_of_this_user(object $pdo, int $user_id) {
    $stmt = $pdo->prepare('SELECT email, gender FROM users WHERE user_id = :user_id');
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
    
}

function sent_friend_request(object $pdo, int $recipent_id, int $from_id) : void {
    //recipent_id, sender_id, status, message
    if(!isset($_SESSION['user_id'])) {
        header("Location: ../../HTML/newsfeed.php?error=Not_Found");
        die('Error Sending Friend Request');
    }

    $sender_id = $from_id;
    $recipent_id = $recipent_id;
    $sender_name = $_SESSION['username'] ?? 'Unknown User';
    $status = 'friend_request';
    $message = 'You have a new friend request from ' . $sender_name;
    $stmt = $pdo->prepare('INSERT INTO notifications (recipient_id, sender_id, status, message) VALUES (:recipient_id, :sender_id, :status, :message)');
    $stmt->bindParam(':recipient_id', $recipent_id, PDO::PARAM_INT);
    $stmt->bindParam(':sender_id', $sender_id, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);
    $stmt->execute();


}



