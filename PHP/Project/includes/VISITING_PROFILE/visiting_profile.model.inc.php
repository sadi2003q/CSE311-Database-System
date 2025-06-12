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
            
        return true;


        
    } catch (PDOException $e) {
        echo '<p>not working '. $e->getMessage() . '</p>';
        return false; // Return false on error
    }
}

