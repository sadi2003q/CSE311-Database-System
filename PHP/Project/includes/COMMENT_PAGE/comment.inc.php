<?php 


declare(strict_types=1);

require_once '../config_session.inc.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {
        $pdo = require_once '../dbh.inc.php';
        require_once 'comment.model.inc.php';



        $userID=$_SESSION['user_id'];
        $postID=$_SESSION['working_on_post'];
        $comment_text=$_POST['user_comment'];

        
        print('Information : <br>');
        print('User Id : '. $userID. '<br>');
        print('post Id : '. $postID. '<br>');
        print('Comment Text : '. $comment_text. '<br>');


        post_the_comment($pdo, $postID, $comment_text);
        print('Comment is now added<br>');

    } catch (Exception $e) {
        print('Error Found '. $e->getMessage());
    }
}







