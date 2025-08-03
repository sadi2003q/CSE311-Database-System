<?php
require_once '../config_session.inc.php';
require_once '../dbh.inc.php';
require_once 'comment.model.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // 🔹 FIRST: Handle comment deletion
    if (isset($_POST['delete_comment'], $_POST['comment_id'], $_POST['post_id'])) {
        
        $postID = (int)$_SESSION['working_on_post'];

        delete_comment($pdo, (int)$_POST['comment_id']);
        
        print('deleted');
        // header("Location: ../../HTML/comment.php?post_id=" . $postID . "&comment_delete=success");
        header("Location: ../../HTML/comment.php?post_id=" . $postID);

        exit(); 
    }

    try {
        if (!isset($_SESSION['user_id'], $_SESSION['working_on_post'], $_POST['user_comment'])) {
            header("Location: ../../HTML/login.php");
            exit();
        }

        $userID = (int)$_SESSION['user_id'];
        $postID = (int)$_SESSION['working_on_post'];
        $comment_text = trim($_POST['user_comment']);

        if (empty($comment_text)) {
            throw new Exception("Comment cannot be empty");
        }

        post_the_comment($pdo, $postID, $comment_text);

        header("Location: ../../HTML/comment.php?post_id=" . $postID . "&comment=success");
        exit();

    } catch (Exception $e) {
        $_SESSION['comment_error'] = $e->getMessage();
        header("Location: ../../HTML/comment.php?post_id=" . $postID . "&comment=success");
        exit();
    }
}