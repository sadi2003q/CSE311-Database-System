<?php
declare(strict_types=1);
require_once 'post_model.inc.php';
require_once 'reaction_model.inc.php'; 

function upload_error_occurred(): void {
    if($_GET['post'] === 'success') {
        echo '
        <div class="success-message">
            <h3>Post Uploaded Successfully</h3>
            <p>Refresh the page for new feeds</p>
        </div>';
        return;
    }

    if (!isset($_SESSION['error_post']) || empty($_SESSION['error_post'])) return;

    $errors = $_SESSION['error_post'];
    echo '<div style="width: 90%; background-color: pink; padding: 10px; border-radius: 10px; margin-top: 10px;">
            <h3 style="font-family: Times New Roman; font-weight: bold; color: orangered">Error Occurred While Uploading</h3>
            <div style="margin-top: 15px; font-family: Times New Roman;">';

    foreach ($errors as $error) {
        echo '<p>' . htmlspecialchars($error) . '</p>';
    }

    echo '</div></div>';
    unset($_SESSION['error_post']);
}

function show_new_suggession_form_database(object $pdo): void {
    $all_profile = fetch_new_profile_for_suggession($pdo);
    if (empty($all_profile)) return;

    echo '<div class="friend-suggestions"><h3>Suggested Profiles</h3>';
    foreach ($all_profile as $profile) {
        if ($_SESSION['user_id'] === $profile['user_id']) continue;

        $imageSrc = $profile['image_url'] 
            ? '../uploads/' . $profile['image_url'] 
            : ($profile['GENDER'] === 'female' 
                ? '../uploads/female_profile_icon_image.jpg' 
                : '../uploads/male_profile_icon_image.png');

        $link = 'visiting_profile.php?profile_id=' . $profile['user_id'];

        echo '<div class="suggestion" style="display: flex; align-items: center; margin-bottom: 10px;">' .
                '<img src="' . $imageSrc . '" alt="Profile" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 10px;" />' .
                '<div><p style="margin: 0; font-weight: bold;">' . htmlspecialchars($profile['username']) . '</p>' .
                '<a href="' . $link . '" style="padding: 4px 8px; background-color: #007bff; color: white; font-size: 12px; border-radius: 4px;">Visit Profile</a></div>' .
            '</div>';
    }
    echo '</div>';
}

function show_new_feed(object $pdo): void {
    $feeds = fetch_all_new_feed($pdo);
    $reaction_types = ['Like' => '👍', 'Love' => '❤️', 'Haha' => '😄', 'Sad' => '😢', 'Angry' => '😡'];
    $user_id = $_SESSION['user_id'];

    foreach ($feeds as $feed) {
        $id = $feed['user_id'];
        $post_id = $feed['post_id'];
        $text = $feed['text_content'] ?? '';
        $image = $feed['image_url'] ?? '';
        $created_at = $feed['created_at'] ?? '';
        $post_maker = fetch_post_maker_info($pdo, $id);
        $post_maker_name = $post_maker['username'] ?? 'Unknown';

        $post_maker_image = !empty($post_maker['image_url']) 
            ? '../uploads/' . $post_maker['image_url'] 
            : ($post_maker['gender'] === 'female' 
                ? '../uploads/female_profile_icon_image.jpg' 
                : '../uploads/male_profile_icon_image.png');

        echo '<div class="post" style="margin-bottom: 2rem; padding: 1rem; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 5px 10px rgba(0,0,0,0.1); max-width: 600px; margin: auto;">';
        echo '<div style="display: flex; align-items: center; margin-bottom: 1rem;">
                <img src="' . $post_maker_image . '" alt="Profile" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; margin-right: 15px; border: 2px solid #ccc;">
                <h3 style="margin: 0;">@' . htmlspecialchars($post_maker_name) . '</h3>
              </div>';

        echo '<p style="font-size: 22px; font-weight: bold; text-align: left; margin: 1rem 0;">' . nl2br(htmlspecialchars($text)) . '</p>';
        if (!empty($image)) {
            echo '<img src="../uploads/' . htmlspecialchars($image) . '" alt="Post image" style="display: block; max-width: 90%; max-height: 400px; margin: 0 auto; border-radius: 10px; box-shadow: 0 8px 16px rgba(0,0,0,0.2);">';
        }

        echo '<div class="meta" style="text-align: right; margin-top: 20px; color: #777; font-size: 13px;">Posted on ' . htmlspecialchars($created_at) . '</div>';

        //REACTION SECTION
        $user_reaction = get_user_reaction($pdo, $user_id, $post_id);
        $reaction_counts = get_reaction_counts($pdo, $post_id);

        echo '<div id="post-' . $post_id . '" class="reactions" style="margin-top: 10px;">';
        foreach ($reaction_types as $reaction => $emoji) {
            $highlight = $user_reaction === $reaction ? 'background-color: lightblue;' : '';
            $count = $reaction_counts[$reaction] ?? 0;
            echo '<button data-reaction="' . $reaction . '" onclick="reactToPost(' . $post_id . ', \'' . $reaction . '\')" 
                    style="' . $highlight . ' margin: 2px; padding: 4px 8px; border-radius: 8px; cursor: pointer;">' .
                    $emoji . ' ' . $reaction . ' (' . $count . ')' .
                 '</button>';
        }
        echo '</div>'; // end reaction container

        echo '</div>'; // end post container
    }
}
?>

<!--JavaScript to handle reactions-->
<script>
    function reactToPost(postId, reactionType) {
        fetch("react_contr.inc.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `post_id=${postId}&reaction_type=${reactionType}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                const emojis = {
                    'Like': '👍', 'Love': '❤️', 'Haha': '😄', 'Sad': '😢', 'Angry': '😡'
                };
                const container = document.querySelector(`#post-${postId}`);
                if (!container) return;

                Object.keys(emojis).forEach(type => {
                    const btn = container.querySelector(`button[data-reaction="${type}"]`);
                    if (btn) {
                        btn.innerText = emojis[type] + " " + type + " (" + data.reaction_counts[type] + ")";
                        btn.style.backgroundColor = (type === data.user_reaction) ? "lightblue" : "";
                    }
                });
            } else {
                alert("Error: " + data.status);
            }
        });
    }
</script>
