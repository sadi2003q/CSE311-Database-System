<?php


declare(strict_types=1);

function show_user_profile_picture() : void {

    $image_path = '../uploads/male_profile_icon_image.png';
    if($_SESSION['gender']==='female'){
        $image_path = '../uploads/female_profile_icon_image.jpg';
    }

    if(isset($_SESSION['image_url'])) {
        $image_path = '../uploads/'.$_SESSION['image_url'];
    }

    echo '<img src="'.$image_path.'" alt="Profile Picture" class="profile-picture" id="profileImage">';

}


function show_user_information_profile_view(): void {

    if(isset($_SESSION['user_id']) and isset($_SESSION['username']) and isset($_SESSION['email']) and isset($_SESSION['gender'])) {

        show_user_profile_picture();

        $username = $_SESSION['username'];
        $email = $_SESSION['email'];
        $gender = $_SESSION['gender'];



        echo '<h1>Welcome, ' . $username . '</h1> <br>';

        echo '<p>Email : '. $email . '|'. 'Gender: ' .$gender .'</p> <br>';

    } else {
        header("location: ../../HTML/login.php?server=failed?function=profile_contr/show_user_information");
        die('Something went wrong');
    }

}

function error_found_while_updating_profile(): void {
    if (empty($_SESSION['error_UpdateProfile'])) {
        return; // No error to display
    }

    $errors = $_SESSION['error_UpdateProfile'];

    echo '<div style="width: 90%; padding: 5px; margin: 10px; background-color: pink; border-radius: 5px">';
    echo '<h3 style="color: orangered; font-family: \'Times New Roman\', Times, serif">Error Occurred</h3>';
    echo '<div style="margin-top: 10px;">';

    foreach ($errors as $error) {
        echo '<p>' . htmlspecialchars($error) . '</p>';
    }

    echo '</div>';
    echo '</div>';

    // Optionally clear the errors after displaying
    $_SESSION['error_UpdateProfile'] = null;
}

function show_all_post_from_user(object $pdo): void {
    
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../../HTML/login.php");
        exit;
    }

    $user_id = $_SESSION['user_id'];
    require_once 'profile_model.php';
    $posts = fetch_all_post_from_user($pdo);

    if (empty($posts)) {
        echo '<p>No Post Found</p>';
        header("Location: ../../HTML/login.php?server=failed&function=newsfeed_model/fetch_all_post_from_user");
        exit;
    }

    foreach ($posts as $post) {
        $post_id = $post['post_id'];
        $post_maker_id = $post['user_id'];
        $username = $_SESSION['username'];
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
        echo '  <form method="POST" action="../includes/POST_REACTION/post_reaction.inc.php?postID=' . $post_id . '&postMakerID=' . $post_maker_id . '&postLikerID=' . $user_id . '&referrer=profile" style="margin: 0; flex: 1;">';
        echo '      <button type="submit" name="react" class="' . $react_class . '" style="width: 100%;">' . $react_text . '</button>';
        echo '  </form>';
        echo '  <a href="comment.php?post_id=' . $post_id . '" class="action-btn" style="flex: 1; text-align: center; text-decoration: none;">Comment</a>';
        echo '</div>';

        echo '</div>';
    }
}