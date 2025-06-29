<?php


declare(strict_types=1);


function upload_error_occurred(): void
{

    if ($_GET['post'] === 'success') {
        echo '
        <div class="success-message">
                    <h3>Post Uploaded Successfully</h3>
                    <p>Refresh the page for new feeds</p>
        </div>
        ';
        return;
    }

    if (!isset($_SESSION['error_post']) || empty($_SESSION['error_post'])) {
        return;
    }

    $errors = $_SESSION['error_post'];

    echo '<div style="width: 90%; background-color: pink; padding: 10px; border-radius: 10px; margin-top: 10px;">
            <h3 style="font-family: \'Times New Roman\', Times, serif; font-weight: bold; color: orangered">
                Error Occurred While Uploading
            </h3>
            <div style="margin-top: 15px; font-family: \'Times New Roman\', Times, serif">';

    foreach ($errors as $error) {
        echo '<p>' . htmlspecialchars($error) . '</p>';
    }

    echo '   </div>
          </div>';

    // Optional: clear errors after displaying
    unset($_SESSION['error_post']);
}

function show_new_suggession_form_database(object $pdo): void
{
    require_once 'post_model.inc.php';
    $all_profile = fetch_new_profile_for_suggession($pdo);

    if (empty($all_profile)) {
        return;
    }

    echo '<div class="friend-suggestions">';
    echo '<h3 class="friend-suggestions">Suggested Profiles</h3>';

    foreach ($all_profile as $profile) {

        if ($_SESSION['user_id'] === $profile['user_id']) {
            continue;
        }

        // Determine image source
        $imageSrc = '';
        if ($profile['image_url']) {
            $imageSrc = '../uploads/' . $profile['image_url']; // Assuming images are stored in an 'uploads' 
        } else {
            if ($profile['GENDER'] == 'male') {
                $imageSrc = '../uploads/male_profile_icon_image.png';
            } else if ($profile['GENDER'] == 'female') {
                $imageSrc = '../uploads/female_profile_icon_image.jpg';
            }
        }


        $link = 'visiting_profile.php?profile_id=' . $profile['user_id'];

        echo '<div class="suggestion" style="display: flex; align-items: center; margin-bottom: 10px;">' .
            '<img src="' . $imageSrc . '" alt="Profile" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 10px;" />' .
            '<div style="padding: 5px;">' .
            '<p style="margin: 0; font-weight: bold;">' . htmlspecialchars($profile['username']) . '</p>' .
            '<a href=" ' . $link . '" style="display: inline-block; padding: 4px 8px; background-color: #007bff; color: white; text-decoration: none; font-size: 12px; border-radius: 4px;">Visit Profile</a>' .
            '</div>' .
            '</div>';
    }

    echo '</div>';
}



function show_new_feed(object $pdo): void
{
    require_once 'post_model.inc.php';

    $feeds = fetch_all_new_feed($pdo);

    foreach ($feeds as $feed) {
        $postMakerID = $feed['user_id'];
        $post_id = $feed['post_id'];
        $text = $feed['text_content'] ?? '';
        $image = $feed['image_url'] ?? '';
        $created_at = $feed['created_at'] ?? '';

        // Fetch post maker info
        $post_maker = fetch_post_maker_info($pdo, $postMakerID);
        $post_maker_name = $post_maker['username'] ?? 'Unknown';

        // Profile image logic
        $post_maker_image = '../uploads/male_profile_icon_image.png';
        if (!empty($post_maker['image_url'])) {
            $post_maker_image = '../uploads/' . $post_maker['image_url'];
        } elseif (($post_maker['gender'] ?? '') === 'female') {
            $post_maker_image = '../uploads/female_profile_icon_image.jpg';
        }

        // Outer container
        echo '<div class="post" style="margin-bottom: 2rem; padding: 1rem; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 5px 10px rgba(0,0,0,0.1); max-width: 600px; margin-left: auto; margin-right: auto;">';

        // Top section: profile image + username (left aligned)
        echo '<div style="display: flex; align-items: center; margin-bottom: 1rem;">
                <img src="' . $post_maker_image . '" alt="Profile" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; margin-right: 15px; border: 2px solid #ccc;">
                <h3 style="margin: 0;">@' . htmlspecialchars($post_maker_name) . '</h3>
              </div>';

        // Text content
        if (empty($image)) {
            echo '<p style="font-size: 22px; font-weight: bold; text-align: left; margin: 1rem 0;">' . nl2br(htmlspecialchars($text)) . '</p>';
        } else {
            echo '<p style="font-size: 16px; text-align: left; margin-bottom: 10px;">' . nl2br(htmlspecialchars($text)) . '</p>';
            echo '<img src="../uploads/' . htmlspecialchars($image) . '" alt="Post image" style="display: block; max-width: 90%; max-height: 400px; margin: 0 auto; border-radius: 10px; box-shadow: 0 8px 16px rgba(0,0,0,0.2);">';
        }

        $current_state = 'React';
        if (check_if_liked_or_not($pdo, (int)$post_id)) {
            $current_state = 'Reacted';
        }

        $button_bg = ($current_state === 'Reacted') ? '#28a745' : '#007bff'; // Green or blue
        $button_hover_bg = ($current_state === 'Reacted') ? '#218838' : '#0056b3'; // Darker green or blue

        // Buttons for Like and Comment with hover animation
        echo '<div style="display: flex; gap: 10px; margin-top: 15px;">
        <form method="POST" action="../includes/POST_REACTION/post_reaction.inc.php?postID=' . ($post_id) . '&&postMakerID=' . $postMakerID . '&&postLikerID=' . $_SESSION['user_id'] . '" style="margin: 0;">
            <button type="submit" name="react" 
                style="padding: 8px 16px; background-color: ' . $button_bg . '; color: white; border: none; border-radius: 5px; cursor: pointer; transition: all 0.3s ease; transform: scale(1);"
                onmouseover="this.style.transform=\'scale(1.1)\'; this.style.backgroundColor=\'' . $button_hover_bg . '\';" 
                onmouseout="this.style.transform=\'scale(1)\'; this.style.backgroundColor=\'' . $button_bg . '\';">'
            . $current_state .
            '</button>
        </form>
        <a href="#" style="text-decoration: none;">
            <button style="padding: 8px 16px; background-color: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; transition: all 0.3s ease; transform: scale(1);" onmouseover="this.style.transform=\'scale(1.1)\'; this.style.backgroundColor=\'#5a6268\';" onmouseout="this.style.transform=\'scale(1)\'; this.style.backgroundColor=\'#6c757d\';">Comment</button>
        </a>
      </div>';

        // Timestamp
        echo '<div class="meta" style="text-align: right; margin-top: 20px; color: #777; font-size: 13px;">Posted on ' . htmlspecialchars($created_at) . '</div>';
        echo '</div>';
    }
}


function check_if_liked_or_not(object $pdo, int $postID): bool {
    try {
        
        $postLikerID = (int)$_SESSION['user_id'];


        $query = "SELECT * FROM LIKES WHERE user_id = :postLikerID AND post_ID = :postID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':postLikerID', $postLikerID, PDO::PARAM_INT);
        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->execute();

        // Check if a row exists
        return $stmt->rowCount() > 0;

    } catch (Exception $e) {
        echo 'Something went wrong: ' . $e->getMessage();
        return false; // Return false on error
    }
}

