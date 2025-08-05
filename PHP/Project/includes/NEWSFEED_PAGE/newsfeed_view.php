<?php

declare(strict_types=1);

require_once 'newsfeed_model.php';


function show_user_information(object $pdo): void {
    $user = find_user_information($pdo);

    if ($user) {
        echo '
            <div style="text-align: left; font-family: Poppins, sans-serif;">
                <p style="font-weight: 600; margin-bottom: 10px; font-size: 1.5rem; color: #333;">' . htmlspecialchars($user['username']) . '</p>
                <p style="color: #555; font-size: 0.95rem; margin-bottom: 10px;">📧 ' . htmlspecialchars($user['email']) . '</p>
                <p style="color: #555; font-size: 0.95rem; margin-bottom: 10px;">🚻 ' . htmlspecialchars($user['GENDER']) . '</p>
            </div>';
        unset($user);
    } else {
        header("Location: ../../HTML/login.php?server=failed&function=newsfeed_model/find_user_information");
        die("Error Occurred");       
    }
}


function show_first_notification(object $pdo, int $userID): void {
    $notification = find_leatest_notification($pdo, $userID);
    
    if (!$notification) {
        echo '<div style="text-align: center; padding: 20px;">
                <i class="fas fa-bell-slash" style="font-size: 24px; color: #6c757d; margin-bottom: 10px;"></i>
                <p style="color: #6c757d; margin: 0;">No new notifications</p>
              </div>';
        return;
    }

    $sender_info = fetch_notification_sender_information($pdo, $notification['sender_id']);
    $sender_name = htmlspecialchars($sender_info['username']);
    $sender_avatar = !empty($sender_info['image_url']) ? 
                    '../uploads/'.$sender_info['image_url'] : 
                    ($sender_info['gender'] === 'female' ? 
                        '../uploads/female_profile_icon_image.jpg' : 
                        '../uploads/male_profile_icon_image.png');

    // Determine notification type and icon
    switch($notification['status']) {
        case 'like':
            $icon = '👍';
            $message = 'liked your post';
            $link = 'comment.php?post_id='.$notification['post_id'];
            break;
        case 'comment':
            $icon = '💬';
            $message = 'commented on your post';
            $link = 'comment.php?post_id='.$notification['post_id'];
            break;
        case 'follow':
            $icon = '👤';
            $message = 'started following you';
            $link = 'visiting_profile.php?profile_id='.$notification['sender_id'];
            break;
        default:
            $icon = '🔔';
            $message = $notification['message'] ?? 'New notification';
            $link = '#';
    }

    // Format timestamp
    $timestamp = new DateTime($notification['created_at']);
    $time_ago = format_time_ago($timestamp);

    echo '<div style="width: 100%; padding: 15px; text-align: center;">
            <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                <img src="'.htmlspecialchars($sender_avatar).'" 
                     style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #e9ecef; margin-right: 10px;">
                <span style="font-weight: 500;">'.$sender_name.'</span>
            </div>
            
            <div style="margin-bottom: 10px; font-size: 14px;">
                <span style="font-size: 16px; margin-right: 5px;">'.$icon.'</span>
                '.$message.'
            </div>
            
            <div style="font-size: 12px; color: #6c757d; margin-bottom: 15px;">
                '.$time_ago.'
            </div>
            
            <a href="'.$link.'" 
               style="display: inline-block; 
                      padding: 5px 15px; 
                      background-color: #4361ee; 
                      color: white; 
                      border-radius: 20px; 
                      text-decoration: none;
                      font-size: 13px;
                      transition: all 0.3s ease;">
                View ' . ($notification['status'] === 'follow' ? 'Profile' : 'Post') . '
            </a>
          </div>';
}

// Helper function to format time as "X time ago"
function format_time_ago(DateTime $date): string {
    $now = new DateTime();
    $diff = $now->diff($date);
    
    if ($diff->y > 0) return $diff->y.' year'.($diff->y > 1 ? 's' : '').' ago';
    if ($diff->m > 0) return $diff->m.' month'.($diff->m > 1 ? 's' : '').' ago';
    if ($diff->d > 0) return $diff->d.' day'.($diff->d > 1 ? 's' : '').' ago';
    if ($diff->h > 0) return $diff->h.' hour'.($diff->h > 1 ? 's' : '').' ago';
    if ($diff->i > 0) return $diff->i.' minute'.($diff->i > 1 ? 's' : '').' ago';
    return 'Just now';
}




