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

function fetch_new_profile_for_suggession(object $pdo): array {
    if (!isset($_SESSION['user_id'])) {
        return []; 
    }

    $user_id = $_SESSION['user_id'];

    // Get other users (excluding current user)
    // $query = "SELECT * FROM USERS WHERE user_id != :user_id and user_id = 5 ORDER BY user_id DESC LIMIT 20";
    
    // $statement = $pdo->prepare($query);
    // $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    // $statement->execute();

    // $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    // return $result;

    $query = "SELECT * FROM USERS"; // No WHERE, ORDER BY, or LIMIT
    
    $statement = $pdo->query($query); // Direct query (no prepare needed for static SQL)
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}



function fetch_all_new_feed(object $pdo) {

    try {
        
        if (!isset($_SESSION['user_id'])) {
            return []; 
        }

        $user_id = $_SESSION['user_id'];

        $query = "SELECT *
            FROM follow f
            JOIN posts p ON f.FOLLOWING_ID = p.user_id
            WHERE f.FOLLOWER_ID = :user_id ";
        
        $statement = $pdo->prepare($query);
        $statement->execute([
            ':user_id' => $user_id
        ]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $result ?? [];

    } catch (Exception $e) {
        echo '<p> Error Found : ' . $e->getMessage() . '</p>';
    }

}


// New version support for both mac and windows
function fetch_post_maker_info(object $pdo, $id) {
    try {
        $uid = (int)$id;

        $query = "Select * from users where user_id = :uid";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;



    } catch (Exception $e) {
        print_r('Exception Found : ' . $e->getMessage());
    }
}



