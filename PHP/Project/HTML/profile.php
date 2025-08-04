<?php
require_once "../includes/config_session.inc.php";
$pdo = require_once "../includes/dbh.inc.php";
require_once "../includes/PROFILE_PAGE/profile_view.php";
?>

<!-- 
    This page allow user to show their progfile update informaiton as well as show their post
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Social Media</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --secondary: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --white: #ffffff;
            --border-radius: 12px;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            --shadow-hover: 0 10px 15px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            overflow-y: auto;
        }

        .navbar {
            background-color: var(--white);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--light-gray);
        }

        .navbar a {
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar a:hover {
            background-color: var(--light-gray);
            transform: scale(1.05);
        }

        .navbar a i {
            font-size: 1.1rem;
        }

        .navbar div {
            display: flex;
            gap: 0.5rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 2rem;
            height: calc(100vh - 60px);
        }

        .profile-section {
            height: 100%;
            padding: 1.5rem 0;
            display: flex;
            flex-direction: column;
        }

        .profile-card {
            background-color: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 2rem;
            text-align: center;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--white);
            box-shadow: var(--shadow);
            margin: 0 auto 1.5rem;
        }

        .profile-card h1 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .profile-card p {
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        .profile-info {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .info-item {
            text-align: center;
        }

        .info-item span {
            display: block;
            font-weight: 600;
            color: var(--dark);
        }

        .info-item small {
            color: var(--gray);
            font-size: 0.8rem;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: var(--primary);
            color: var(--white);
            border: none;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            text-align: center;
            margin: 0.25rem 0;
            width: 100%;
        }

        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .btn-secondary {
            background-color: var(--secondary);
        }

        .btn-secondary:hover {
            background-color: #d91a6d;
        }

        .profile-actions {
            margin-top: 1rem;
        }

        .posts-section {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            padding: 1.5rem 0;
            height: 100%;
            overflow-y: auto;
        }

        .post {
            background-color: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            transition: var(--transition);
        }

        .post:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .post-user {
            font-weight: 600;
            color: var(--dark);
        }

        .post-time {
            color: var(--gray);
            font-size: 0.8rem;
            margin-left: auto;
        }

        .post-content {
            margin-bottom: 1rem;
            font-size: 1rem;
            line-height: 1.6;
        }

        .post-image {
            width: 100%;
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
            max-height: 400px;
            object-fit: cover;
        }

        .error-message {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 0.75rem 1.25rem;
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        .action-btn {
    background: none;
    border: none;
    color: #6c757d;          /* gray */
    font-weight: 600;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 6px;
    transition: background-color 0.2s ease;
    width: 100%;
    text-align: center;
}

.action-btn:hover {
    background-color: #f0f0f0;  /* light gray */
}

.action-btn.reacted {
    color: #0d6efd;           /* primary blue */
    font-weight: 700;
}

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                height: auto;
                overflow: visible;
            }

            .profile-section,
            .posts-section {
                height: auto;
                overflow: visible;
            }
            
            .navbar {
                flex-direction: column;
                padding: 1rem;
                gap: 0.5rem;
            }
            
            .navbar div {
                width: 100%;
                justify-content: space-between;
            }
            
            .navbar a {
                flex-grow: 1;
                text-align: center;
                padding: 0.5rem;
                font-size: 0.85rem;
            }
            
            .navbar a:last-child {
                width: 100%;
                margin-top: 0.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .navbar a {
                font-size: 0.8rem;
            }
            
            .navbar a i {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <div></div>
        <div>
            <a href="newsfeed.php"><i class="fas fa-home"></i> Home</a>
            <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
            <a href="#"><i class="fas fa-bell"></i> Notifications</a>
        </div>
        
    </nav>

    <div class="container">
        <!-- Left Column - Profile Info -->
        <div class="profile-section">
            <div class="profile-card">
                <?php show_user_information_profile_view(); ?>
                
                <div class="profile-actions">
                    <a href="follower.php" class="btn">
                        <i class="fas fa-users"></i> Followers & Following
                    </a>
                    <a href="profile_image.php" class="btn btn-secondary">
                        <i class="fas fa-camera"></i> Upload Image
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Column - Posts -->
        <div class="posts-section">
            <?php show_all_post_from_user($pdo); ?>
        </div>
    </div>
</body>
</html>