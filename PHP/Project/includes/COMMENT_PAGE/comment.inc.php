<?php
require_once '../config_session.inc.php';
require_once '../dbh.inc.php';
require_once 'comment.model.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // 🔹 Handle comment update
    if (isset($_POST['update_comment'], $_POST['comment_id'], $_POST['edited_comment'], $_POST['post_id'])) {
        try {
            $commentID = (int)$_POST['comment_id'];
            $editedText = trim($_POST['edited_comment']);
            $postID = (int)$_POST['post_id'];

            if (empty($editedText)) {
                throw new Exception("Comment cannot be empty");
            }

            update_comment($pdo, $commentID, $editedText);

            header("Location: ../../HTML/comment.php?post_id=" . $postID . "&comment_updated=success");
            exit();

        } catch (Exception $e) {
            $_SESSION['comment_error'] = $e->getMessage();
            header("Location: ../../HTML/comment.php?post_id=" . $postID . "&comment_error=update_failed");
            exit();
        }
    }
    
    // 🔹 Handle comment deletion
    if (isset($_POST['delete_comment'], $_POST['comment_id'], $_POST['post_id'])) {
        try {
            $postID = (int)$_SESSION['working_on_post'];
            $commentID = (int)$_POST['comment_id'];

            delete_comment($pdo, $commentID);
            
            header("Location: ../../HTML/comment.php?post_id=" . $postID . "&comment_delete=success");
            exit();
        } catch (Exception $e) {
            $_SESSION['comment_error'] = $e->getMessage();
            header("Location: ../../HTML/comment.php?post_id=" . $postID . "&comment_error=delete_failed");
            exit();
        }
    }

    // 🔹 Handle new comment submission
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
        header("Location: ../../HTML/comment.php?post_id=" . $postID . "&comment_error=submission_failed");
        exit();
    }
}

