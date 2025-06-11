<?php 

    require_once '../includes/config_session.inc.php';
    $pdo = require_once '../includes/dbh.inc.php';

    require_once '../includes/SUGGESTED_PROFILE/suggested_profile.view.inc.php'


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Profile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #F3F4F6;
        }

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

        .button-group button.delete {
            background: #EF4444;
        }

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
    <nav class="navbar">
        <button onclick="window.history.length > 1 ? history.back() : window.location.href='fallback.php';">Back</button>
    </nav>

    <div class="container">
        <div class="profile-section">
             <?php show_profile_picture(); ?>

            

            <?php show_prifile_name(); ?>

            <?php show_basic_information_of_this_user($pdo); ?>

            <form action="../includes/SUGGESTED_PROFILE/suggested_profile.inc.php?profile_id=".$_GET['profile_id']." method="POST">
                <div class="button-group">
                    <button type="submit" name="sent_request">Add Friend</button>
                </div>
            </form>
        </div>

        <div class="posts-section">
            <h3>Posts</h3>
            <!-- <div class="post">
                <div class="post-header">
                    <img src="profile.jpg" alt="Avatar" />
                    <h3>User Name</h3>
                </div>
                <p>This is a sample post text with some content.</p>
                <img src="post.jpg" alt="Sample" style="width:100%; border-radius:8px;" />
                <div class="actions">
                    <button>Like (3)</button>
                    <button>Comment (1)</button>
                </div>
            </div> -->

            <?php show_all_post_of_this_user($pdo); ?>

        </div>
    </div>
</body>
</html>