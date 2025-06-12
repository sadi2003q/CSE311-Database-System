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

        // $query = "SELECT * FROM posts WHERE USER_ID=:user_id";
        // $statement = $pdo->prepare($query);
        // $statement->execute([':user_id'=>$user_id]);

        // $result = $statement->fetch(PDO::FETCH_ASSOC);
        // return $result;


        $query = "SELECT * FROM posts WHERE user_id = :user_id ORDER BY created_at DESC";
        $statement = $pdo->prepare($query);
        $statement->execute([':user_id' => $user_id]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result ?: [];


        


    } catch (PDOException $e) {
        echo '<p>not working '. $e->getMessage() . '</p>';
    }
    
}




