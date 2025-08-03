<?php 


declare(strict_types=1);

require_once '../config_session.inc.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo = require_once '../dbh.inc.php';
        require_once 'comment.model.inc.php';

        if (!isset($_SESSION['user_id'], $_SESSION['working_on_post'], $_POST['user_comment'])) {
            header("Location: ../../HTML/login.php");
        }

        $userID = (int)$_SESSION['user_id'];
        $postID = (int)$_SESSION['working_on_post'];
        $comment_text = trim($_POST['user_comment']);

        if (empty($comment_text)) {
            throw new Exception("Comment cannot be empty");
        }

        post_the_comment($pdo, (int)$postID, (string)$comment_text);
        
        // Redirect back to the comment page after successful submission
        header("Location: ../../HTML/comment.php?post_id=" . $postID . "&comment=success");
        exit();
        
    } catch (Exception $e) {
        // Handle error - you might want to store it in session and display on the page
        $_SESSION['comment_error'] = $e->getMessage();
        header("Location: ../../HTML/comment.php?post_id=" . $postID . "&comment=success");
        exit();
    }
}







