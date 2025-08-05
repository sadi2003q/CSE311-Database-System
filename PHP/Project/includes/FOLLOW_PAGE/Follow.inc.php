<?php 


declare(strict_types=1);

require_once '../includes/config_session.inc.php';


// Fetch all those users who is being followed 
function fetch_all_following_from_Database($pdo, int $uid = -1) {
    try {
        
        // By default it will show the following of the current loggin user, 
        // but when variable is passed through the url then it will take that as the user_id
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

// Fetching all those users who is following 
function fetch_all_follower_from_Database(object $pdo) {
    try {

        // By default it will show the follower of the current loggin user, 
        // but when variable is passed through the url then it will take that as the user_id
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

// Fetch the name from database
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


// view level code: 
// view level code: 
// it will show all the following
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

    echo '<div style="display: flex; flex-direction: column; gap: 15px;">';

    foreach ($followings as $following) {
        $id = $following['FOLLOWING_ID'];
        $name = fetch_name_from_Database($pdo, $id);

        // Correct link construction
        $link = "visiting_profile.php?profile_id=" . $id;
        if($id == $_SESSION['user_id']) {
            $link = "profile.php";
        }

        echo '
            <div class="follow-card">
                <span style="font-size: 18px; font-weight: bold;">' . htmlspecialchars($name) . '</span>
                <a href="' . $link . '" class="visit-btn">Visit Profile</a>
            </div>
        ';
    }

    echo '</div>';
}

// this will show all the follower 
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

    echo '<div class="follow-header">Total Followers: ' . count($followers ?? []) . '</div>';

    if (empty($followers)) {
        echo '<p class="follow-empty">No followers found</p>';
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

    echo '<div style="display: flex; flex-direction: column; gap: 15px;">';

    foreach ($followers as $follower) {
        // Changed from FOLLOWING_ID to FOLLOWER_ID
        $id = $follower['FOLLOWER_ID'];
        $name = fetch_name_from_Database($pdo, $id);

        $link = "visiting_profile.php?profile_id=" . $id;
        if($id == $_SESSION['user_id']) {
            $link = "profile.php";
        }

        echo '
            <div class="follow-card">
                <span style="font-size: 18px; font-weight: bold;">' . htmlspecialchars($name) . '</span>
                <a href="' . $link . '" class="visit-btn">Visit Profile</a>
            </div>
        ';
    }

    echo '</div>';
}