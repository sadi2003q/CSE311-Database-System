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

function show_all_comment(object $pdo, int $user_id) {
    if (!isset($_GET['post_id'])) {
        echo "No post ID provided.";
        return;
    }

    $postID = (int) $_GET['post_id'];
    $all_comments = fetch_all_comment($pdo, $postID);

    if (!$all_comments || count($all_comments) === 0) {
        echo "<p style='color: var(--gray);'>No comments yet.</p>";
        return;
    }

    foreach ($all_comments as $comment) {
        $commentID = $comment['comment_id'];
        $comment_user_id = $comment['user_id'];
        $text = $comment['comment_text'];
        $created_at = new DateTime($comment['created_at']);

        $user_info = fetch_post_maker_information($pdo, $comment_user_id);
        $username = htmlspecialchars($user_info['username'] ?? 'Unknown');
        $post_maker_id = fetch_Post_Maker_ID($pdo, $comment['post_id']);

        $profile_img = '../uploads/male_profile_icon_image.png';
        if (!empty($user_info['image_url'])) {
            $profile_img = '../uploads/' . $user_info['image_url'];
        } elseif (($user_info['gender'] ?? '') === 'female') {
            $profile_img = '../uploads/female_profile_icon_image.jpg';
        }

        $condition = $user_id == $comment_user_id;
        $condition2 = $post_maker_id == $user_id;

        echo '
        <div class="comment-box" style="position: relative;" id="comment-'.$commentID.'">
            <!-- COMMENT HEADER -->
            <div class="comment-header" style="display: flex; align-items: center; justify-content: space-between; width: 100%; position: relative;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <img src="' . htmlspecialchars($profile_img) . '" alt="Avatar" class="comment-avatar">
                    <div class="comment-user-info">
                        <span class="comment-username">' . $username . '</span>
                        <span class="comment-time">' . $created_at->format('F j, Y \a\t g:i a') . '</span>
                    </div>
                </div>';

        // Show edit button only if condition is true
        // Show delete button if condition or condition2 is true
        if ($condition || $condition2) {
            echo '<div style="display: flex; gap: 0.5rem;">';

            if ($condition) {
                echo '
                    <button type="button" class="edit-icon-button" 
                            title="Edit Comment" onclick="enableEdit('.$commentID.')">
                        <i class="fas fa-edit"></i>
                    </button>';
            }

            echo '
                    <form method="POST" action="../includes/COMMENT_PAGE/comment.inc.php" style="margin: 0;">
                        <input type="hidden" name="comment_id" value="' . $commentID . '">
                        <input type="hidden" name="post_id" value="' . $postID . '">
                        <button type="submit" name="delete_comment" class="delete-icon-button" 
                                title="Delete Comment">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>';
        }

        echo '
            </div>

            <!-- COMMENT TEXT -->
            <div id="comment-text-'.$commentID.'">
                <p class="comment-text">' . nl2br(htmlspecialchars($text)) . '</p>
            </div>
            
            <!-- EDIT FORM (HIDDEN BY DEFAULT) -->
            <div id="edit-form-'.$commentID.'" style="display: none;">
                <form method="POST" action="../includes/COMMENT_PAGE/comment.inc.php" class="edit-comment-form">
                    <input type="hidden" name="comment_id" value="'.$commentID.'">
                    <input type="hidden" name="post_id" value="'.$postID.'">
                    <textarea name="edited_comment" class="edit-comment-input">'.htmlspecialchars($text).'</textarea>
                    <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem;">
                        <button type="submit" name="update_comment" class="save-edit-btn">
                            <i class="fas fa-save"></i> Save
                        </button>
                        <button type="button" class="cancel-edit-btn" onclick="cancelEdit('.$commentID.')">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>';
    }
}




function show_like_and_comment_count(object $pdo) {

    $like_count = find_the_number_of_like($pdo);
    $comment_count = fetch_the_number_of_comment($pdo);


    echo '
    <div style="
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    ">
        <div style="display: flex; align-items: center; gap: 0.5rem; color: #4361ee; font-weight: 600; cursor: pointer">
            <i class="fas fa-thumbs-up"></i>
            <span>'. $like_count . ' Likes</span>
        </div>
        <div style="display: flex; align-items: center; gap: 0.5rem; color: #3a0ca3; font-weight: 600; cursor: pointer">
            <i class="fas fa-comment"></i>
            <span>'. $comment_count . ' Comments</span>
        </div>
    </div>';
}