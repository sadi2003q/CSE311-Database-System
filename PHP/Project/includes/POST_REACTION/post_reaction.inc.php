<?php 

declare(strict_types=1);





if($_SERVER['REQUEST_METHOD']=='POST') {
    try {
        
        if(isset($_GET['postID'])) {
            echo "Post id Found";
            like_the_post();
            
        } else {
            echo "Post id not Found";
        }



    } catch (Exception $e) {
        die();
    }
}






function like_the_post() {
    try {
        
        $pdo = require_once '../dbh.inc.php';
        
    } catch (Exception $e) {
        echo 'something is wrong here ' . $e->getMessage() ;
    }
}



