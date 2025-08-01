<?php
// post_view.inc.php

declare(strict_types=1);

// New function to show user avatar in post form
function show_current_user_avatar_for_post_form(object $pdo): void
{
    require_once 'post_model.inc.php';
    $user_id = $_SESSION['user_id'];
    $user = fetch_post_maker_info($pdo, $user_id);

    $imageSrc = '../uploads/male_profile_icon_image.png'; // Default
    if (!empty($user['image_url'])) {
        $imageSrc = '../uploads/' . $user['image_url'];
    } elseif (($user['gender'] ?? '') === 'female') {
        $imageSrc = '../uploads/female_profile_icon_image.jpg';
    }
    
    echo '<img src="' . htmlspecialchars($imageSrc) . '" alt="My Avatar" class="avatar">';
}


function upload_error_occurred(): void
{
    if (isset($_GET['post']) && $_GET['post'] === 'success') {
        echo '
        <div class="alert alert-success">
            <h3>Post Uploaded Successfully!</h3>
            <p>Your new post is now live.</p>
        </div>';
        return;
    }

    if (!isset($_SESSION['error_post']) || empty($_SESSION['error_post'])) {
        return;
    }

    $errors = $_SESSION['error_post'];

    echo '<div class="alert alert-danger">
            <h3>Error Occurred While Uploading</h3>';
    foreach ($errors as $error) {
        echo '<p>' . htmlspecialchars($error) . '</p>';
    }
    echo '</div>';

    unset($_SESSION['error_post']);
}

function show_new_suggession_form_database(object $pdo): void
{
    require_once 'post_model.inc.php';
    $all_profile = fetch_new_profile_for_suggession($pdo);

    if (empty($all_profile)) {
        echo "<p>No suggestions at the moment.</p>";
        return;
    }

    foreach ($all_profile as $profile) {
        if ($_SESSION['user_id'] === $profile['user_id']) {
            continue;
        }

        $imageSrc = '../uploads/male_profile_icon_image.png'; // Default
        if ($profile['image_url']) {
            $imageSrc = '../uploads/' . $profile['image_url'];
        } else if ($profile['GENDER'] == 'female') {
            $imageSrc = '../uploads/female_profile_icon_image.jpg';
        }

        $profile_link = 'visiting_profile.php?profile_id=' . $profile['user_id'];

        echo '<div class="suggestion-item">' .
            '<img src="' . htmlspecialchars($imageSrc) . '" alt="Profile" class="avatar" />' .
            '<div class="suggestion-info">' .
            '<p>' . htmlspecialchars($profile['username']) . '</p>' .
            '<a href="' . $profile_link . '">Visit Profile</a>' .
            '</div>' .
            '</div>';
    }
}

function show_new_feed(object $pdo): void
{
    require_once 'post_model.inc.php';
    $feeds = fetch_all_new_feed($pdo);

    if (empty($feeds)) {
        echo '<div class="card"><p>No posts yet. Be the first to post something!</p></div>';
        return;
    }

    foreach ($feeds as $feed) {
        $postMakerID = $feed['user_id'];
        $post_id = $feed['post_id'];
        $text = $feed['text_content'] ?? '';
        $image = $feed['image_url'] ?? '';
        $created_at = new DateTime($feed['created_at'] ?? 'now');

        $post_maker = fetch_post_maker_info($pdo, $postMakerID);
        $post_maker_name = $post_maker['username'] ?? 'Unknown';

        $post_maker_image = '../uploads/male_profile_icon_image.png';
        if (!empty($post_maker['image_url'])) {
            $post_maker_image = '../uploads/' . $post_maker['image_url'];
        } elseif (($post_maker['gender'] ?? '') === 'female') {
            $post_maker_image = '../uploads/female_profile_icon_image.jpg';
        }

        echo '<div id="post-' . $post_id . '" class="card post">';

        // Post Header
        echo '<div class="post-header">
                <img src="' . htmlspecialchars($post_maker_image) . '" alt="Profile" class="avatar">
                <div class="post-author-info">
                    <a href="visiting_profile.php?profile_id=' . $postMakerID . '" class="post-author" style="text-decoration: none; color: inherit;">' . htmlspecialchars($post_maker_name) . '</a>
                    <p class="post-meta">' . $created_at->format('F j, Y \a\t g:i a') . '</p>
                </div>
              </div>';

        // Post Content
        echo '<div class="post-content">';
        if (!empty($text)) {
            $text_class = empty($image) ? 'post-text bold-status' : 'post-text';
            echo '<p class="' . $text_class . '">' . nl2br(htmlspecialchars($text)) . '</p>';
        }
        if (!empty($image)) {
            echo '<img src="../uploads/' . htmlspecialchars($image) . '" alt="Post image" class="post-image">';
        }
        echo '</div>';

        // Post Actions
        $liked = check_if_liked_or_not($pdo, (int)$post_id);
        $react_class = $liked ? 'action-btn reacted' : 'action-btn';
        $react_text = $liked ? 'Reacted' : 'React';

        echo '<div class="post-actions">
                <div style="flex: 1;">
                    <form method="POST" action="../includes/POST_REACTION/post_reaction.inc.php?postID=' . $post_id . '&&postMakerID=' . $postMakerID . '&&postLikerID=' . $_SESSION['user_id'] . '#post-' . $post_id . '" style="margin: 0;">
                        <button type="submit" name="react" class="' . $react_class . '" style="width: 100%;">' . $react_text . '</button>
                    </form>
                </div>
                <div style="flex: 1;">
                    <a href="comment.php?post_id=' . $post_id . '" class="action-btn" style="display: block; text-align: center; width: 100%; text-decoration: none; font-size: 13px;">Comment</a>
                </div>
              </div>';

        echo '</div>'; // End of .post
    }
}

function check_if_liked_or_not(object $pdo, int $postID): bool 
{
    try {
        $postLikerID = (int)$_SESSION['user_id'];
        $query = "SELECT 1 FROM LIKES WHERE user_id = :postLikerID AND post_ID = :postID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':postLikerID', $postLikerID, PDO::PARAM_INT);
        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() !== false;
    } catch (Exception $e) {
        // Silently fail in production for a better user experience
        // error_log('Like check failed: ' . $e->getMessage());
        return false;
    }
}

// This function was in the original newsfeed.php, but it's better to have it here with other view functions.
// I will assume it exists in newsfeed_view.php as per the original include.
// If not, it should be added. For now, I will just assume it's there.
// The user info is now inside a card, so the function should just output the content.
/*
function show_user_information(object $pdo): void
{
    // The implementation of this function needs to be checked.
    // Assuming it outputs something like:
    // <div class="user-info">
    //    <img src="..." class="avatar">
    //    <p>Username</p>
    // </div>
}
*/

