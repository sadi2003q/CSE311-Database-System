<?php 
require_once '../includes/config_session.inc.php';
$pdo = require_once '../includes/dbh.inc.php';
require_once "../includes/VISITING_PROFILE/visiting_profile.view.inc.php";



?>

<!-- 
    This page allow user to visit other profile post follower and following list, also to follow or unfollow this account

-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Profile</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #F3F4F6;
        }

        /* Navigation Bar */
        .navbar {
            background: #1E3A8A;
            padding: 1rem;
            color: #fff;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar button {
            background: none;
            border: none;
            color: #fff;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
        }

        .navbar button::before {
            content: "←";
        }

        .container {
            max-width: 1200px;
            margin: 1.5rem auto;
            padding: 0 1rem;
        }

        /* Profile Section */
        .profile-section {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .profile-section img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
        }

        .profile-section h2 {
            margin-bottom: 1rem;
            color: #1E3A8A;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .button-group button {
            background: #3B82F6;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }

        /* Posts Section */
        .posts-section {
            background: #fff;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .post {
            margin-bottom: 1.5rem;
        }

        .post-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .post-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .post .actions button {
            background: none;
            border: none;
            color: #1E3A8A;
            font-weight: bold;
            cursor: pointer;
            margin-right: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 0 0.5rem;
            }

            .profile-section img {
                width: 80px;
                height: 80px;
            }

            .button-group {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>

<body>

    <!-- 
        Top Navigation Bar
        -> Back button to return to the previous page
    -->
    <nav class="navbar">
        <button onclick="history.back()">Back</button>
    </nav>

    <div class="container">

        <!-- 
            Profile Section
            -> Displays visiting user's profile picture and name
            -> Data loaded from database using `show_all_information($pdo)`
        -->
        <div class="profile-section">
            <?php show_all_information($pdo); ?>

            <!-- 
                Follow/Unfollow Form
                -> Calls `show_appropriate_button()` to show "Follow" or "Unfollow"
            -->
            <form action="../includes/VISITING_PROFILE/visiting_profile.inc.php" method="POST">
                <div class="button-group">
                    <?php show_appropriate_button($pdo); ?>
                </div>
            </form>

            <!-- 
                Followers & Following Link
                -> Displays button if profile is allowed to expose this info
            -->
            <?php show_Follower_Following_button(); ?>
        </div>

        <!-- 
            Posts Section
            -> Displays all posts made by the visiting user
        -->
        <div class="posts-section">
            <h3>Posts</h3>
            <?php show_all_post($pdo); ?>
        </div>

    </div>

    <!-- 
        Force refresh page from cache if revisited using back button
        -> Prevents outdated follow/unfollow state
    -->
    <script>
        window.addEventListener('pageshow', function (event) {
            if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                window.location.reload();
            }
        });
    </script>

</body>
</html>