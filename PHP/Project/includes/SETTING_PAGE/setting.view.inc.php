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