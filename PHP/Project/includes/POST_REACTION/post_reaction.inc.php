<?php 

declare(strict_types=1);
require_once '../config_session.inc.php';

/**
 * This script handles the server-side logic for liking or unliking a post.
 * It checks for a POST request and expects postID, postMakerID, and postLikerID as GET parameters.
 * Note: Using GET parameters to modify data is not a standard practice, POST or other methods are preferred for state changes.
 */
if($_SERVER['REQUEST_METHOD']=='POST') {
    try {
        
        // Check if the required parameters are set in the URL.
        if(isset($_GET['postID']) && isset($_GET['postMakerID']) && isset($_GET['postLikerID']) ) {
            
            $postID = (int)$_GET['postID'];
            $postMakerID = (int)$_GET['postMakerID']; // Note: postMakerID is retrieved but not used in this block.
            $postLikerID = (int)$_GET['postLikerID'];
            
            $referrer = isset($_GET['referrer']) ? $_GET['referrer'] : 'newsfeed';

            switch ($referrer) {
                case "profile":
                    react_this_post($postID, $postLikerID, "profile");
                case "visiting_profile":
                    react_this_post($postID, $postLikerID, "visiting_profile");
                default:
                    react_this_post($postID, $postLikerID, "newsfeed");
            }

            // Process the like/unlike action.
            


            
            
        } else {
            // If required parameters are missing, output an error message.
            echo "Post id not Found";
        }



    } catch (Exception $e) {
        // Catch any exceptions and terminate the script to prevent further errors.
        die();
    }
}

/**
 * Checks if a user has already liked a specific post.
 *
 * @param int $postID The ID of the post.
 * @param int $postLikerID The ID of the user who might have liked the post.
 * @return bool True if the user has liked the post, false otherwise.
 */
function check_if_liked_or_not(int $postID, int $postLikerID): bool {
    try {
        // Require the database handler.
        $pdo = require '../dbh.inc.php';

        // SQL query to find a like from the user on the specific post.
        $query = "SELECT * FROM LIKES WHERE user_id = :postLikerID AND post_ID = :postID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':postLikerID', $postLikerID, PDO::PARAM_INT);
        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->execute();

        // If a row is found, it means the post is liked.
        return $stmt->rowCount() > 0;

    } catch (Exception $e) {
        // Output error message and return false on exception.
        echo 'Something went wrong: ' . $e->getMessage();
        return false; // Return false on error
    }
}


/**
 * Adds a like to a post from a specific user.
 * This involves adding a record to the LIKES table and incrementing the like count in the POSTS table.
 *
 * @param int $postID The ID of the post to be liked.
 * @param int $postLikerID The ID of the user who is liking the post.
 */
function like_this_post(int $postID, int $postLikerID) {
    try {
        // Require the database handler.
        $pdo = require '../dbh.inc.php';

        // Insert a new record into the LIKES table.
        $query = "INSERT INTO LIKES (user_id, post_id) VALUES (:user_id, :post_id)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $postLikerID, PDO::PARAM_INT);
        $stmt->bindParam(':post_id', $postID, PDO::PARAM_INT);
        $stmt->execute();

        // Increment the like count in the POSTS table.
        $query = "UPDATE POSTS 
                SET LIKE_COUNT = LIKE_COUNT + 1 
                WHERE POST_ID = :post_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':post_id', $postID, PDO::PARAM_INT);
        $stmt->execute();

    } catch (Exception $e) {
        // Output error message on exception.
        echo 'Something went wrong: ' . $e->getMessage();
    }
}

function like_notification(int $senderID, int $recipientID, int $postID): bool {
    try {
        $pdo = require '../dbh.inc.php';
        
        // Corrected SQL with proper commas and column names
        $query = "INSERT INTO notifications (recipient_id, sender_id, post_id, status) 
                 VALUES (:recipient_id, :sender_id, :post_id, 'liked')";
        
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

function fetch_postMakerID(int $postID): ?int {
    try {
        $pdo = require '../dbh.inc.php';
        $query = "SELECT USER_ID FROM POSTS WHERE POST_ID = :postID LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':postID' => $postID]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int)$result['USER_ID'] : null;
        
    } catch (PDOException $e) {
        error_log("Failed to fetch post maker ID: " . $e->getMessage());
        return null;
    }
}

/**
 * Removes a like from a post from a specific user.
 * This involves deleting a record from the LIKES table and decrementing the like count in the POSTS table.
 *
 * @param int $postID The ID of the post to be unliked.
 * @param int $postLikerID The ID of the user who is unliking the post.
 */
function unlike_this_post(int $postID, int $postLikerID) {
    try {
        // Require the database handler.
        $pdo = require '../dbh.inc.php';

        // Delete the like record from the LIKES table.
        $query = "DELETE FROM LIKES WHERE user_id = :user_id AND post_id = :post_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $postLikerID, PDO::PARAM_INT);
        $stmt->bindParam(':post_id', $postID, PDO::PARAM_INT);
        $stmt->execute();

        // Decrement the like count in the POSTS table.
        $query = "UPDATE POSTS 
                SET LIKE_COUNT = LIKE_COUNT - 1 
                WHERE POST_ID = :post_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':post_id', $postID, PDO::PARAM_INT);
        $stmt->execute();

    } catch (Exception $e) {
        // Output error message on exception.
        echo 'Something went wrong: ' . $e->getMessage();
    }
}

/**
 * Handles the core logic of reacting to a post (liking or unliking).
 * It checks if the post is already liked by the user. If yes, it unlikes the post.
 * If no, it likes the post. After the action, it redirects the user to the newsfeed.
 *
 * @param int $postID The ID of the post being reacted to.
 * @param int $postLikerID The ID of the user reacting to the post.
 */

function react_this_post(int $postID, int $postLikerID, string $destination) {
    try {
        // Determine where to redirect back to
        $referrer = 'newsfeed'; // default
        if (isset($_GET['referrer']) && $_GET['referrer'] === 'comment') {
            $referrer = 'comment';
        }

        $liked = check_if_liked_or_not($postID, $postLikerID);

        // Perform like/unlike
        if ($liked) {
            unlike_this_post($postID, $postLikerID);
            $status = 'unliked';
        } else {
            like_this_post($postID, $postLikerID);
            $postMakerId = fetch_postMakerID($postID);
            like_notification((int)$postLikerID, (int)$postMakerId, (int)$postID);
            $status = 'liked';
        }

        // Determine redirection path
        if ($referrer === 'comment') {
            $redirect = "Location: ../../HTML/comment.php?post_id=$postID&$status#post-$postID";
        } else {
            switch ($destination) {
                case "profile":
                    $file = 'profile.php';
                    break;
                case "visiting_profile":
                    $profileID=$_GET['profileID'];
                    $file = 'visiting_profile.php?profile_id=' . $profileID .'';
                    break;
                default:
                    $file = 'newsfeed.php';
            }
            $redirect = "Location: ../../HTML/$file?$status#post-$postID";
        }

        header($redirect);
        exit;

    } catch (Exception $e) {
        echo 'Something went wrong: ' . $e->getMessage();
    }
}



