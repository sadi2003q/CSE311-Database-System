<?php 

declare(strict_types=1);

function error_found_while_updating_profile(): void
{
    if (empty($_SESSION['update_profile_error'])) {
        return;
    }

    $errors = $_SESSION['update_profile_error'];
    $content = '';

    foreach ($errors as $key => $message) {
        $content .= '<p>' . htmlspecialchars($message) . '</p>';
    }

    echo '
    <div class="Error_box">
        <div class="Error_box_insider">
            <h2>Error Found</h2>
            ' . $content . '
        </div>
    </div>
    ';

    // Clear errors after showing
    $_SESSION['update_profile_error'] = null;
}



function apply_success_border(): void
{
    if (!isset($_GET['update'])) {
        return;
    }

    $field = '';

    switch ($_GET['update']) {
        case 'username_success':
            $field = 'username';
            break;
        case 'email_success':
            $field = 'email';
            break;
        case 'password_success':
            $field = 'current_password,new_password';
            break;
        default:
            return;
    }

    echo '<style>';
    foreach (explode(',', $field) as $id) {
        echo "#$id { border: 2px solid #4ADE80 !important; box-shadow: 0 0 5px rgba(34,197,94,0.5); }";
    }
    echo '</style>';
}


function Fetch_Username(object $pdo, int $userID)  {
    $query = "SELECT * FROM USERS WHERE USER_ID = :user_id";
    $statement = $pdo->prepare($query);
    $statement->execute([':user_id' => $userID]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}



function show_all_activities_log(object $pdo): void {
    
    $user_id = (int)$_SESSION['user_id'];
    $query = "SELECT * FROM FOLLOW WHERE FOLLOWER_ID = :user_id ORDER BY FOLLOWER_DATE ASC";
    $statement = $pdo->prepare($query);
    $statement->execute([':user_id' => $user_id]);
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    


    echo '<div style="background-color: #f9f9f9; padding: 16px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); font-family: Arial, sans-serif; max-width: 98%; margin: 20px auto;">';
    echo '<h4 style="text-decoration: underline; margin-bottom: 16px; color: #333;">All Following</h4>';

    foreach ($results as $result) {
        echo '<div style="padding: 10px 0; border-bottom: 1px solid #e0e0e0; color: #555;">';
        $name = Fetch_Username($pdo, (int)$result['FOLLOWING_ID']) ?? 'No Name';
        echo '👤 <a>Started Following </a> <strong>' . ($name['username']) . ' </strong><br>';
        echo '🕒 <span style="font-size: 0.9em;">on: ' . ($result['FOLLOWER_DATE']) . '</span>';
        echo '</div>';
    }

    echo '</div>';




    $query = "SELECT * FROM POSTS WHERE user_id = :user_id ORDER BY created_at ASC";
    $statement = $pdo->prepare($query);
    $statement->execute([':user_id' => $user_id]);
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);


    echo '<div style="background-color: #fefefe; padding: 16px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); font-family: Arial, sans-serif; max-width: 98%; margin: 20px auto;">';
    echo '<h4 style="text-decoration: underline; margin-bottom: 16px; color: #333;">Your Posts</h4>';

    if (count($posts) === 0) {
        echo '<p style="color: #777;">You haven\'t posted anything yet.</p>';
    }

    foreach ($posts as $post) {
        echo '<div style="padding: 14px 0; border-bottom: 1px solid #e0e0e0; color: #444;">';
        echo '📝 <strong>Text:</strong> ' . nl2br(htmlspecialchars($post['text_content'])) . '<br>';

        if (!empty($post['image_url'])) {
            echo '<img src="' . htmlspecialchars($post['image_url']) . '" alt="Post Image" style="max-width: 100%; margin-top: 10px; border-radius: 4px;"><br>';
        }

        echo '❤️ <strong>Likes:</strong> ' . (int)$post['like_count'] . ' &nbsp; 💬 <strong>Comments:</strong> ' . (int)$post['comment_count'] . '<br>';
        echo '📅 <span style="font-size: 0.9em;">Posted on: ' . htmlspecialchars($post['created_at']) . '</span>';
        echo '</div>';
    }

    echo '</div>';

    

    $query = "SELECT DISTINCT u.USERNAME, l.created_at
        FROM LIKES l
        JOIN POSTS p ON l.POST_ID = p.post_id
        JOIN USERS u ON p.user_id = u.user_id
        WHERE l.user_id = :user_id
        ORDER by l.created_at ASC";

    $statement = $pdo->prepare($query);
    $statement->execute([':user_id' => $user_id]);
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);


    echo '<div style="background-color: #fffefc; padding: 16px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); font-family: Arial, sans-serif; max-width: 98%; margin: 20px auto;">';
    echo '<h4 style="text-decoration: underline; margin-bottom: 16px; color: #333;">Liked Posts Activity</h4>';

    if (count($posts) === 0) {
        echo '<p style="color: #777;">You haven\'t liked any posts yet.</p>';
    }

    foreach ($posts as $post) {
        echo '<div style="background-color: #fdfdfd; padding: 16px; margin-bottom: 14px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);">';
        echo '<div style="font-size: 15px; color: #333;">';
        echo '👍 <strong>You liked a post of</strong> <span style="color: #2a7ae2;">' . htmlspecialchars($post['USERNAME']) . '</span>';
        echo '</div>';
        echo '<div style="font-size: 13px; color: #666; margin-top: 6px;">🕒 Liked on: ' . htmlspecialchars($post['created_at']) . '</div>';
        echo '</div>';
    }

    echo '</div>';



    


}