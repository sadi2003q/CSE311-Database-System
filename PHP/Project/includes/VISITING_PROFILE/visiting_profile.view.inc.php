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
    echo '<img src="'. $image . '" alt="Profile Picture" class="profile-picture" />';
    echo '<h1>' . htmlspecialchars($username) . '</h1>';
    echo '<p>' . htmlspecialchars($email) . '</p>';
    echo '<p>Gender: ' . htmlspecialchars(ucfirst($gender)) . '</p>';
}

function show_all_post(object $pdo): void {
    $user_id = (int)$_GET['profile_id'];
    require_once 'visiting_profile.model.inc.php';
    $posts = fetch_all_post_from_database($pdo, $user_id);

    if (empty($posts)) {
        echo '<p>No Post Found</p>';
        return;
    }

    $profile_info = fetch_all_information_from_database($pdo, (int)$user_id);
    
    foreach ($posts as $post) {
        $post_id = $post['post_id'];
        $post_maker_id = $post['user_id'];
        $username = $profile_info['username'];
        $created_at = (new DateTime($post['created_at']))->format('F j, Y \a\t g:i a');
        $post_text_content = $post['text_content'];
        $post_image_url = $post['image_url'];

        echo '<div class="post" style="margin-bottom: 2rem;">';
        echo '<h4>@' . htmlspecialchars($username) . '</h4>';
        
        if (!empty($post_image_url)) {
            echo '<p style="
                    font-size: 1rem;
                    color: #444;
                    margin-top: 15px;
                    margin-bottom: 20px;
                    line-height: 1.5;
                    font-weight: 500;
                    font-style: normal;
                    text-align: left;
                    opacity: 0.85;
                    font-weight: 550;
                    
                ">' . nl2br(htmlspecialchars($post_text_content)) . '</p>';
            echo '<img src="../uploads/' . htmlspecialchars($post_image_url) . '" alt="Post image" style="display: block; max-width: 80%; max-height: 400px; object-fit: cover; border-radius: 6px; margin: 1rem auto 10px; box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);">';
        } else {
            echo '<p style="margin-top: 15px; margin-bottom: 20px; font-size: 25px; font-weight: 550;">' . nl2br(htmlspecialchars($post_text_content)) . '</p>';
        }

        echo '<div class="meta" style="font-size: 0.8rem; color: #6c757d; opacity: 0.6; font-style: italic;">Posted on ' . $created_at . '</div>';

        // LIKE and COMMENT BUTTONS
        $liked = check_if_liked_or_not($pdo, (int)$post_id, (int)$user_id);
        // $liked = true;
        $react_class = $liked ? 'action-btn reacted' : 'action-btn';
        $react_text = $liked ? 'Reacted' : 'React';
        

        echo '<div class="post-actions" style="margin-top: 1rem; display: flex; gap: 1rem;">';
        echo '  <form method="POST" action="../includes/POST_REACTION/post_reaction.inc.php?postID=' . $post_id . '&postMakerID=' . $post_maker_id . '&postLikerID=' . $user_id . '&referrer=visiting_profile&profileID='.$post_maker_id.'" style="margin: 0; flex: 1;">';
        echo '      <button type="submit" name="react" class="' . $react_class . '" style="width: 100%;">' . $react_text . '</button>';
        echo '  </form>';
        echo '  <a href="comment.php?post_id=' . $post_id . '" class="action-btn" style="flex: 1; text-align: center; text-decoration: none;">Comment</a>';
        echo '</div>';

        echo '</div>';
    }
}

function show_appropriate_button(object $pdo): void {
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
            echo '<button type="submit" name="action" value="unfollow" class="btn btn-unfollow"><i class="fas fa-user-minus"></i> Unfollow</button>';
        } else {
            echo '<button type="submit" name="action" value="follow" class="btn btn-follow"><i class="fas fa-user-plus"></i> Follow</button>';
        }
    } catch (PDOException $e) {
        echo '<p>Error: ' . $e->getMessage() . '</p>';
    }
}

