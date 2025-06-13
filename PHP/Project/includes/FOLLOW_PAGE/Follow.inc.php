<?php 


declare(strict_types=1);

require_once '../includes/config_session.inc.php';



function fetch_all_following_from_Database($pdo, int $uid = -1) {
    try {
        
        $user_id = $_SESSION['user_id'];
        if (isset($_GET['profile_id']) && !empty($_GET['profile_id'])) {
            $user_id = (int) $_GET['profile_id'];
        } 

        $query = "SELECT * FROM FOLLOW WHERE FOLLOWER_ID = :user_id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':user_id', $user_id);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result ?? [];

    } catch(Exception $e) {
        echo '<p>Error Found: ' . $e->getMessage() . '</p>';
        die();
    }
}


function fetch_all_follower_from_Database(object $pdo) {
    try {

        $user_id = $_SESSION['user_id'];
        if (isset($_GET['profile_id']) && !empty($_GET['profile_id'])) {
            $user_id = (int) $_GET['profile_id'];
        }

        $query = "SELECT * FROM FOLLOW WHERE FOLLOWING_ID = :user_id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':user_id', $user_id);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result ?? [];


    } catch(Exception $e) {
        echo '<p>Error Found: ' . $e->getMessage() . '</p>';
        die();
    }
}


function fetch_name_from_Database(object $pdo, int $uid) {
    try {
        $query = "SELECT username FROM USERS WHERE user_id = :uuid";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':uuid', $uid, PDO::PARAM_INT);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['username'] : null;

    } catch (Exception $e) {
        echo '<p>Some problem found while dealing with fetch_name_from_Database function: ' . $e->getMessage() . '</p>';
        die();
    }
}



function show_all_following(object $pdo) {

    $followings = fetch_all_following_from_Database($pdo);
    
    echo '
        <style>
            .follow-header {
                font-size: 20px;
                font-weight: 600;
                margin-bottom: 10px;
                color: #1f2937;
            }

            .follow-empty {
                font-size: 16px;
                color: #6b7280;
                margin-top: 20px;
            }
        </style>
    ';

    echo '<div class="follow-header">Total Followings: ' . count($followings ?? []) . '</div>';

    if (empty($followings)) {
        echo '<p class="follow-empty">No following found</p>';
        return;
    }

    
    echo '
    <style>
        .follow-card {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 8px;
            background: #f9f9f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: box-shadow 0.3s ease;
        }
        .follow-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .visit-btn {
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .visit-btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
    ';

    // Container
    echo '<div style="display: flex; flex-direction: column; gap: 15px;">';

    foreach ($followings as $following) {
        $id = $following['FOLLOWING_ID'];
        $name = fetch_name_from_Database($pdo, $id);

        echo '
            <div class="follow-card">
                <span style="font-size: 18px; font-weight: bold;">' . htmlspecialchars($name) . '</span>
                <a href="#" class="visit-btn">Visit Profile</a>
            </div>
        ';
    }

    echo '</div>';
}



function show_all_follower(object $pdo) {

    $followers = fetch_all_follower_from_Database($pdo);
    
    echo '
        <style>
            .follow-header {
                font-size: 20px;
                font-weight: 600;
                margin-bottom: 10px;
                color: #1f2937;
            }

            .follow-empty {
                font-size: 16px;
                color: #6b7280;
                margin-top: 20px;
            }
        </style>
    ';

    echo '<div class="follow-header">Total Followings: ' . count($followers ?? []) . '</div>';

    if (empty($followers)) {
        echo '<p class="follow-empty">No following found</p>';
        return;
    }

    
    echo '
    <style>
        .follow-card {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 8px;
            background: #f9f9f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: box-shadow 0.3s ease;
        }
        .follow-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .visit-btn {
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .visit-btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
    ';

    // Container
    echo '<div style="display: flex; flex-direction: column; gap: 15px;">';

    foreach ($followers as $follower) {
        $id = $follower['FOLLOWING_ID'];
        $name = $follower['FOLLOWER_NAME'];

        echo '
            <div class="follow-card">
                <span style="font-size: 18px; font-weight: bold;">' . htmlspecialchars($name) . '</span>
                <a href="#" class="visit-btn">Visit Profile</a>
            </div>
        ';
    }

    echo '</div>';
}




