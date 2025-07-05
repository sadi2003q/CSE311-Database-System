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

