<?php 

declare(strict_types=1);

require_once('comment.model.inc.php');



function show_this_post(object $pdo) {

    if (isset($_GET['post_id'])) {

        $_SESSION['working_on_post'] = $_GET['post_id'];

        $post_id = (int) $_GET['post_id'];
        $post_info = fetch_the_post($pdo, $post_id);
        $post_maker = fetch_post_maker_information($pdo, $post_info['user_id']);


        $postMakerID = $post_info['user_id'];
        $post_id = $post_info['post_id'];
        $text = $post_info['text_content'] ?? '';
        $image = $post_info['image_url'] ?? '';
        $created_at = new DateTime($post_info['created_at'] ?? 'now');

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
        $current_id = $_SESSION['user_id'];
        $liked = check_if_liked_or_not($pdo, (int)$post_id, (int)$current_id);
        // $liked = true;
        $react_class = $liked ? 'action-btn reacted' : 'action-btn';
        $react_text = $liked ? 'Reacted' : 'React';

        echo '<div class="post-actions">
                <div style="flex: 1;">
                    <form method="POST" action="../includes/POST_REACTION/post_reaction.inc.php?postID=' . $post_id . '&postMakerID=' . $postMakerID . '&postLikerID=' . $_SESSION['user_id'] . '&referrer=comment#post-' . $post_id . '" style="margin: 0;">
                        <button type="submit" name="react" class="' . $react_class . '" style="width: 100%;">' . $react_text . '</button>
                    </form>
                </div>
                <div style="flex: 1;">
                    <button type="button" class="action-btn focus-comment-btn" style="width: 100%;">Comment</button>
                </div>
            </div>';

        echo '</div>'; // End of .post



        




        
    } else {
        echo "No post ID provided in URL.";
    }

    

    
}