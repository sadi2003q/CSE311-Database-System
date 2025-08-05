<?php


declare(strict_types=1);



function fetch_all_information_from_database(object $pdo, int $user_id) {

    try {

        $query = "SELECT * FROM USERS WHERE USER_ID=:user_id";
        $statement = $pdo->prepare($query);
        $statement->execute([':user_id'=>$user_id]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;


    } catch (PDOException $e) {
        echo '<p>not working '. $e->getMessage() . '</p>';
    }
    
}


function fetch_all_post_from_database(object $pdo, int $user_id) {

    try {

        $query = "SELECT * FROM posts WHERE USER_ID=:user_id";
        $statement = $pdo->prepare($query);
        $statement->execute([':user_id'=>$user_id]);

        $result = $statement->fetchALL(PDO::FETCH_ASSOC);
        return $result ?? [];


        // $query = "SELECT * FROM posts WHERE user_id = :user_id ORDER BY created_at DESC";
        // $statement = $pdo->prepare($query);
        // $statement->execute([':user_id' => $user_id]);
        // $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        // return $result ?: [];


        


    } catch (PDOException $e) {
        echo '<p>not working '. $e->getMessage() . '</p>';
    }
    
}

function check_follower(object $pdo, int $current_id, int $visiting_id): bool {
    try {
        $query = "SELECT 1 FROM FOLLOW 
                 WHERE FOLLOWER_ID = :follower_id 
                 AND FOLLOWING_ID = :following_id 
                 LIMIT 1";
        
        $statement = $pdo->prepare($query);
        $statement->execute([
            ':follower_id' => $current_id,
            ':following_id' => $visiting_id
        ]);

        // If a row is found, return true (user follows)
        return (bool) $statement->fetch(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        echo '<p>not working '. $e->getMessage() . '</p>';
        return false; // Return false on error
    }
}

function follow_now(object $pdo, int $current_id, int $visiting_id)  : bool {
    try {
        $name = $_SESSION['username'];
        $gender = $_SESSION['GENDER'] ?? 'male';
        $follower_id = $current_id;
        $following_id = $visiting_id;


        $query = "
            INSERT INTO FOLLOW (
                FOLLOWER_ID, FOLLOWING_ID, FOLLOWER_NAME, FOLLOWER_GENDER
            ) VALUES (
                :follower_id, :following_id, :follower_name, :follower_gender
            )
        ";

        $statement = $pdo->prepare($query);
        $statement->execute([
            ':follower_id'     => $follower_id,
            ':following_id'    => $following_id,
            ':follower_name'   => $name,
            ':follower_gender' => $gender
        ]);

        follow_notification($pdo, (int)$current_id, (int)$visiting_id);
            
        return true;


        
    } catch (PDOException $e) {
        echo '<p>not working '. $e->getMessage() . '</p>';
        return false; // Return false on error
    }
}


function unfollow_now(object $pdo, int $current_id, int $visiting_id): bool {
    try {
        $pdo->beginTransaction();
        
        $query = "DELETE FROM FOLLOW WHERE FOLLOWER_ID = ? AND FOLLOWING_ID = ? LIMIT 1";
        $statement = $pdo->prepare($query);
        $statement->execute([$current_id, $visiting_id]);
        
        $rowsDeleted = $statement->rowCount();
        $pdo->commit();
        
        return $rowsDeleted > 0;
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Unfollow failed: " . $e->getMessage());
        return false;
    }
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



function follow_notification(object $pdo, int $currentID, int $toFOllowID) {

    // recipient_id	sender_id status
    $followerID = $currentID;
    $query = "INSERT INTO notifications (recipient_id, sender_id, status) value 
            (:recipent_id, :sender_id, 'follow')";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':recipent_id' => $toFOllowID,
        ':sender_id' => $followerID
    ]);
    return true;
}