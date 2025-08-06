<?php

declare(strict_types=1);
require_once 'notification.model.inc.php';

function show_all_notification(object $pdo, int $userID): void
{
    $all_notifications = fetch_all_notifications($pdo, $userID);

    // Add notification-specific styles
    echo '<style>
        
    </style>';

    echo '<div class="notification-container">
            <div class="notification-panel">
                <div class="panel-header">
                    <h2 class="panel-title">Notifications</h2>
                    <form method="POST" action="../includes/NOTIFICATION_PAGE/notification.inc.php">
                        <button type="submit" class="mark-all-read">Mark All as Read</button>
                    </form>
                </div>
                <div class="notifications-list">';

    if (empty($all_notifications)) {
        echo '<div class="empty-state">
                <div class="empty-state-icon"><i class="fas fa-bell-slash"></i></div>
                <h3>No notifications yet</h3>
                <p>When you receive notifications, they\'ll appear here</p>
              </div>';
    } else {
        foreach ($all_notifications as $notification) {
            $notification_sender_info = fetch_notification_sender_information($pdo, $notification['sender_id']);
            $sender_name = htmlspecialchars($notification_sender_info['username']);
            $sender_avatar = !empty($notification_sender_info['image_url']) ?
                '../uploads/' . $notification_sender_info['image_url'] : ($notification_sender_info['gender'] === 'female' ?
                    '../uploads/female_profile_icon_image.jpg' :
                    '../uploads/male_profile_icon_image.png');

            // Format timestamp
            $timestamp = new DateTime($notification['created_at']);
            $formatted_time = $timestamp->format('M j, Y \a\t g:i a');

            // Determine notification type and icon
            $notification_type = $notification['status'];
            $icon_class = '';
            $message = '';

            $is_follow_notification = false;

            switch ($notification_type) {
                case 'liked':
                    $icon_class = 'fas fa-thumbs-up';
                    $message = 'liked your post';
                    break;
                case 'commented':
                    $icon_class = 'fas fa-comment';
                    $message = 'commented on your post';
                    break;
                case 'follow':
                    $icon_class = 'fas fa-user-plus';
                    $message = 'started following you';
                    $is_follow_notification = true;
                    break;
                default:
                    $icon_class = 'fas fa-bell';
                    $message = $notification['message'] ?? 'sent you a notification';
            }

            echo '<div class="notification-item ' . ($notification['state'] == 0 ? 'unread' : '') . '">
        <div class="profile-avatar">
            <img src="' . htmlspecialchars($sender_avatar) . '" alt="' . $sender_name . '" />
        </div>
        <div class="notification-content">
            <div class="notification-header">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <span class="user-name">' . $sender_name . '</span>
                        <i class="reaction-icon ' . $icon_class . '"></i>
                        <span class="notification-message">' . $message . '</span>
                    </div>
                    ' . ($notification['state'] == 0 ? '<span style="color: #4361ee; font-size: 20px;">●</span>' : '') . '
                </div>
                <span class="timestamp">' . $formatted_time . '</span>
            </div>';

            if ($notification['post_id'] || $is_follow_notification) {
                echo '<div class="post-preview">
                        <span class="post-message">' . $message . '</span>';

                if ($is_follow_notification) {
                    echo '<a href="visiting_profile.php?profile_id=' . $notification['sender_id'] . '" class="post-link">View profile →</a>';
                } else {
                    echo '<a href="comment.php?post_id=' . $notification['post_id'] . '" class="post-link">View post →</a>';
                }

                echo '</div>';
            }







            echo '</div>
                </div>';
        }
    }

    echo '</div></div></div>'; // Close notifications-list, panel and container
}
