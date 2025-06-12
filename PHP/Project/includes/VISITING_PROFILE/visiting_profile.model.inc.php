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










