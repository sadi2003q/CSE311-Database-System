<?php 

declare(strict_types=1);






function fetch_post_from_database(object $pdo, int $post_id) {
    
    try {
        $query = "SELECT * FROM POST WHERE POST_ID=:postID";
        $statement = $pdo->prepare($query);
        $statement->execute([
            ':postID' => $post_id
        ]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;


    } catch (Exception $e) {
        echo 'Something is wrong with fetch_post_from_Database function : ' . $e->getMessage();
    }

}


function fetch_post_maker_info(object $pdo, int $id) {
    try {
        $uid = (int)$id;

        $query = "Select * from users where user_id = :uid";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;



    } catch (Exception $e) {
        print_r('Exception Found : ' . $e->getMessage());
    }
}







function show_the_post(object $pdo): void {
    
    // Checking if the Post_ID is available in the url or not
    if(!isset($_GET['post_id'])) {
        echo 'Something is wrong cannot find the Post id inside URL';
        return;
    }


    // Fetching the post
    $post_id = $_GET['post_id'];
    $post = fetch_post_from_database($pdo, (int)$post_id);
        
    




}

