<?php 


declare(strict_types=1);

require_once '../includes/config_session.inc.php';




function show_all_information(object $pdo): void {


    require_once 'visiting_profile.model.inc.php';
    $user_id = $_GET['profile_id'];
    $_SESSION['current_profile_being_visited'] = $user_id;
    

    // Fetching from Database
    $result = fetch_all_information_from_database($pdo, (int)$user_id);
    

    // storing into variable
    $username = $result['username'];
    $email = $result['email'];
    $gender = $result['GENDER'];


    $image = '../uploads/male_profile_icon_image.png';
    if(!empty($result['image_url'])) {
        $image = '../uploads/'.$result['image_url'];
    } else {
        if($gender=='female') {
            $image = '../uploads/female_profile_icon_image.jpg';
        }
    }

    // Display All Information of the User
    echo '<img src="'. $image . '" alt="Profile Picture" />';
    echo '<h2>' . $username . '</h2>';
    echo '<p style="margin: 10px;"> ' . $email . '</p>';

    return;
}

function show_all_post(object $pdo): void {
    


    $user_id = (int)$_GET['profile_id'];
    print_r($user_id);

    require_once 'visiting_profile.model.inc.php';
    $posts = fetch_all_post_from_database($pdo, $user_id);


    if (empty($posts)) {
        echo '<p>No Post Found</p>';
        return;
    }


    $profile_info = fetch_all_information_from_database($pdo, (int)$user_id);
    

    foreach ($posts as $post) {
        $username = $profile_info['username'];
        $created_at = $post['created_at'];
        $post_text_content = $post['text_content'];
        $post_image_url = $post['image_url'];
        

        if (!empty($post_image_url)) {
            // Post with image
            echo '<div class="post">
                <h4>@'.$username.'</h4>
                <p>'.$post_text_content.'</p>
                <p> ' . $post_image_url . '</p>
                <img src="../uploads/'.$post_image_url.'" alt="Post image" style="display: block; max-width: 80%; max-height: 400px; background-image:cover;  border-radius: 6px; margin: 1rem auto 10px; box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);">
                <div class="meta">Posted on '.$created_at.'</div>
              </div>';
        } else {
            // Post without image
            echo '<div class="post">
                <h4>@'.$username.'</h4>
                <p style="margin-top: 15px; margin-bottom: 20px; font-size: 25px; font-weight: 550;">'.$post_text_content.'</p>
                <div class="meta">Posted on '.$created_at.'</div>
              </div>';
        }


    }
}


function show_appropriate_button(object $pdo) : void {

    try {
        $visitor_id = $_SESSION['user_id'];
        $visiting_id = $_SESSION['current_profile_being_visited'];


        $query = "SELECT 1 FROM FOLLOW 
                WHERE FOLLOWER_ID = :follower_id 
                AND FOLLOWING_ID = :following_id 
                LIMIT 1";
        
        $statement = $pdo->prepare($query);
        $statement->execute([
            ':follower_id' => $visitor_id,
            ':following_id' => $visiting_id
        ]);
        
        
        $is_following = (bool) $statement->fetch(PDO::FETCH_ASSOC);

        if($is_following) {
            echo '<button name="action" value="unfollow" style="background-color: #f44336; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Unfollow</button>';
            
        } else if(!$is_following) {
            echo '<button name="action" value="follow" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Follow</button>';
            
        }
    } catch (PDOException $e) {
        echo '<p>not working '. $e->getMessage() . '</p>';
    }
    

}



