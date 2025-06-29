<?php 

declare(strict_types=1);





if($_SERVER['REQUEST_METHOD']=='POST') {
    try {
        
        if(isset($_GET['postID']) && isset($_GET['postMakerID']) && isset($_GET['postLikerID']) ) {
            
            $postID = (int)$_GET['postID'];
            $postMakerID = (int)$_GET['postMakerID'];
            $postLikerID = (int)$_GET['postLikerID'];

            react_this_post($postID, $postLikerID);


            
            
        } else {
            echo "Post id not Found";
        }



    } catch (Exception $e) {
        die();
    }
}


function check_if_liked_or_not(int $postID, int $postLikerID): bool {
    try {
        $pdo = require '../dbh.inc.php';

        $query = "SELECT * FROM LIKES WHERE user_id = :postLikerID AND post_ID = :postID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':postLikerID', $postLikerID, PDO::PARAM_INT);
        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->execute();

        // Check if a row exists
        return $stmt->rowCount() > 0;

    } catch (Exception $e) {
        echo 'Something went wrong: ' . $e->getMessage();
        return false; // Return false on error
    }
}



function like_this_post(int $postID, int $postLikerID) {
    try {
        $pdo = require '../dbh.inc.php';

        $query = "INSERT INTO LIKES (user_id, post_id) VALUES (:user_id, :post_id)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $postLikerID, PDO::PARAM_INT);
        $stmt->bindParam(':post_id', $postID, PDO::PARAM_INT);
        $stmt->execute();

    } catch (Exception $e) {
        echo 'Something went wrong: ' . $e->getMessage();
    }
}


function unlike_this_post(int $postID, int $postLikerID) {
    try {
        $pdo = require '../dbh.inc.php';

        $query = "DELETE FROM LIKES WHERE user_id = :user_id AND post_id = :post_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $postLikerID, PDO::PARAM_INT);
        $stmt->bindParam(':post_id', $postID, PDO::PARAM_INT);
        $stmt->execute();

    } catch (Exception $e) {
        echo 'Something went wrong: ' . $e->getMessage();
    }
}





function react_this_post(int $postID, int $postLikerID) {
    try {
        

        if (check_if_liked_or_not($postID, $postLikerID)==True) {
            unlike_this_post($postID, $postLikerID);
            header("Location: ../../HTML/newsfeed.php?unliked");
            return;
        } else {
            like_this_post($postID, $postLikerID);
            header("Location: ../../HTML/newsfeed.php?liked");
        }

        die("successful");
        

    } catch (Exception $e) {
        echo 'Something went wrong: ' . $e->getMessage();
    }
}



