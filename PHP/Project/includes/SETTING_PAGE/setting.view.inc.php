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
        echo '👤 <strong>User ID:</strong> ' . ($result['FOLLOWING_ID']) . '<br>';
        echo '🕒 <span style="font-size: 0.9em;">Followed on: ' . ($result['FOLLOWER_DATE']) . '</span>';
        echo '</div>';
    }

    echo '</div>';


}