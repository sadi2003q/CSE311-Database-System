<?php
// --> Import session configuration and database connection
require_once "../includes/config_session.inc.php";
$pdo = require_once "../includes/dbh.inc.php";

// --> Include feed and post logic view
require_once "../includes/NEWSFEED_PAGE/newsfeed_view.php";
require_once "../includes/NEWSFEED_PAGE/post_view.inc.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News Feed</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Modern UI Reset & Variables */
        :root {
            --primary-color: #1877F2;
            --primary-hover: #166FE5;
            --background-color: #F0F2F5;
            --card-background: #FFFFFF;
            --text-color: #050505;
            --secondary-text-color: #65676B;
            --border-color: #dddfe2;
            --shadow-1: 0 1px 2px rgba(0, 0, 0, 0.1);
            --shadow-2: 0 2px 8px rgba(0, 0, 0, 0.15);
            --border-radius: 8px;
            --font-family: 'Poppins', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--background-color);
            font-family: var(--font-family);
            color: var(--text-color);
            height: 100%;
        }
        body::-webkit-scrollbar {
            display: none;
        }

        body {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;     /* Firefox */
        }

        /* Layout */
        .container {
            display: flex;
            max-width: 1280px;
            margin: 1.5rem auto;
            gap: 1.5rem;
            padding: 0 1rem;
            height: 95vh; /* Keep this to span the full screen */
            overflow: hidden; /* Prevent scrolling of parent */
        }

        .main-content {
            flex: 2;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            height: 100%; /* Full viewport height */
            overflow-y: auto; /* Enable scroll */
            scrollbar-width: none; /* Firefox */
        }

        .main-content::-webkit-scrollbar {
            display: none; /* Chrome, Safari */
        }

        .main-content {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;     /* Firefox */
        }
        

        .sidebar {
            flex: 1;
            max-width: 360px;
            position: sticky;
            /* top: 80px; */
            /* Navbar height + margin */
            height: calc(100vh - 80px);
        }

        /* Navbar */
        .navbar {
            background: var(--card-background);
            padding: 0 2rem;
            height: 60px;
            color: var(--text-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-1);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }

        .navbar-links {
            display: flex;
            gap: 2rem;
        }

        .navbar-links a {
            color: var(--secondary-text-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: color 0.2s ease;
        }

        .navbar-links a:hover,
        .navbar-links a.active {
            color: var(--primary-color);
        }

        .hamburger {
            display: none;
            background: none;
            border: none;
            color: var(--text-color);
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Card Base Style */
        .card {
            background: var(--card-background);
            padding: 1rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-1);
        }

        /* Post Form */
        .post-form {
            padding: 1.5rem;
        }

        .post-form form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .post-form-input {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .post-form textarea {
            width: 100%;
            padding: 0.75rem;
            resize: none;
            border: none;
            border-radius: 20px;
            background-color: var(--background-color);
            font-family: var(--font-family);
            font-size: 1rem;
            outline: none;
        }

        .post-form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.5rem;
            border-top: 1px solid var(--border-color);
        }

        .post-form-actions label {
            cursor: pointer;
            color: var(--secondary-text-color);
            font-weight: 500;
        }

        .post-form-actions input[type="file"] {
            display: none;
        }

        .btn {
            padding: 0.5rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            font-family: var(--font-family);
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: #fff;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        /* Post Card */
        .post {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .post-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .post-author-info {
            display: flex;
            flex-direction: column;
        }

        .post-author {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .post-meta {
            font-size: 0.8rem;
            color: var(--secondary-text-color);
        }

        .post-content .post-text {
            margin-bottom: 1rem;
            line-height: 1.5;
            font-size: 1.1rem;
            /* Slightly larger for readability */
        }

        .post-content .post-text.bold-status {
            font-weight: 600;
            /* Make it bold */
        }

        .post-content .post-image {
            max-width: 100%;
            height: auto;
            /* Maintain aspect ratio */
            max-height: 400px;
            /* Limit height to prevent excessively tall images */
            border-radius: var(--border-radius);
            object-fit: contain;
            /* Ensure the whole image is visible */
            display: block;
            /* Remove extra space below image */
            margin: 0 auto;
            /* Center the image */
        }

        .post-actions {
            display: flex;
            justify-content: space-between;
            padding-top: 0.5rem;
            border-top: 1px solid var(--border-color);
            gap: 0.5rem;
        }

        .action-btn {
            background: none;
            border: none;
            color: var(--secondary-text-color);
            font-weight: 600;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 6px;
            transition: background-color 0.2s ease;
            width: 100%;
            text-align: center;
        }

        .action-btn:hover {
            background-color: #F2F2F2;
        }

        .action-btn.reacted {
            color: var(--primary-color);
            font-weight: 700;
        }

        /* Sidebar */
        .sidebar-section {
            margin-bottom: 1.5rem;
        }

        .sidebar-section h3 {
            font-size: 1.1rem;
            color: var(--secondary-text-color);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-info .avatar {
            width: 50px;
            height: 50px;
        }

        .user-info p {
            font-weight: 600;
        }

        .suggestions-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            max-height: 400px;
            /* Or adjust as needed */
            overflow-y: auto;
            padding-bottom: 2rem;
            padding-right: 0.5rem;
            /* Allow space for scrollbar */
        }

        .suggestions-list::-webkit-scrollbar {
            width: 6px;
        }

        .suggestions-list::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        .suggestion-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .suggestion-info {
            flex-grow: 1;
        }

        .suggestion-info p {
            font-weight: 500;
            font-size: 0.9rem;
        }

        .suggestion-info a {
            display: inline-block;
            font-size: 0.8rem;
            text-decoration: none;
            background-color: var(--primary-color);
            color: #fff;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            transition: background-color 0.2s ease;
        }

        .suggestion-info a:hover {
            background-color: var(--primary-hover);
        }

        /* Alert Messages */
        .alert {
            width: 100%;
            margin-top: 10px;
            padding: 1rem;
            border-radius: var(--border-radius);
            font-family: var(--font-family);
        }

        .alert-success {
            background-color: #D4EDDA;
            color: #155724;
            border: 1px solid #C3E6CB;
        }

        .alert-danger {
            background-color: #F8D7DA;
            color: #721C24;
            border: 1px solid #F5C6CB;
        }

        .alert h3 {
            margin: 0 0 0.5rem 0;
        }

        .left-sidebar {
            max-width: 260px;
            flex: 1;
            position: sticky;
            /* top: 80px; */
            height: calc(100vh - 80px);
        }

        .desktop-only {
            display: none;
        }

        .left-sidebar.desktop-only {
            max-width: 260px;
            flex: 1;
            position: relative;
            height: 100vh; /* Full viewport height */
            overflow-y: auto; /* Enable scroll */
            scrollbar-width: none; /* Firefox */
        }

        .left-sidebar.desktop-only::-webkit-scrollbar {
            display: none; /* Chrome, Safari */
        }

        

        @media (min-width: 992px) {
            .desktop-only {
                display: block;
            }
        }



        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                display: none;
            }

            .container {
                justify-content: center;
            }

            .main-content {
                flex: 1;
                max-width: 680px;

            }
        }

        /* Allow Reacted button to have hover effect like Comment */
        .action-btn.reacted:hover {
            background-color: #F2F2F2;
        }

        @media (max-width: 768px) {
            .navbar-links {
                display: none;
            }

            .hamburger {
                display: block;
            }

            .container {
                padding: 0;
                margin: 0;
            }

            .main-content {
                gap: 0.5rem;
            }

            .card {
                border-radius: 0;
                box-shadow: none;
                border-bottom: 1px solid var(--border-color);
            }

            .post-form {
                margin-bottom: 0.5rem;
            }

            /* Mobile Sidebar (Drawer) */
            .sidebar {
                display: block;
                position: fixed;
                top: 0;
                left: -100%;
                height: 100%;
                width: 280px;
                background: var(--card-background);
                z-index: 1001;
                overflow-y: auto;
                transition: left 0.3s ease-in-out;
                box-shadow: var(--shadow-2);
                padding: 1.5rem;
            }

            .sidebar.active {
                left: 0;
            }

            .sidebar .nav-links-mobile {
                display: flex;
                flex-direction: column;
                gap: 1rem;
                margin-bottom: 2rem;
            }

            .sidebar .nav-links-mobile a {
                color: var(--text-color);
                text-decoration: none;
                font-weight: 500;
                font-size: 1.1rem;
            }
        }

        @media (min-width: 992px) {
            .nav-links-mobile {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        

        <a href="newsfeed.php" class="navbar-brand">Social</a>
        <div class="navbar-links">
            <a href="newsfeed.php" class="active">Home</a>
            <a href="profile.php">Profile</a>
            <a href="#">Notifications</a>
            <a href="logout.php">Logout</a>
        </div>
        <button class="hamburger" onclick="toggleSidebar()">☰</button>
    </nav>

    <div class="container">
        <div class="left-sidebar desktop-only">

            <!-- Profile Information -->
            <div class="card sidebar-section" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                <?php show_user_information($pdo); ?>
            </div>


            <!-- Notification -->
            <div class="card sidebar-section" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                <?php show_user_information($pdo); ?>
            </div>
            

            <!-- Setting -->
            <div class="card sidebar-section" style="height: 200px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: transform 0.3s ease;" onclick="window.location.href='setting.php'" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1.0)'">
    <div style="display: flex; align-items: center;">
        <svg style="width: 24px; height: 24px; margin-right: 8px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="3"></circle>
            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
        </svg>
        <span style="font-size: 16px;">Settings</span>
    </div>
</div>


        </div>

        <div class="main-content">
            <div class="card post-form">
                <form action="../includes/NEWSFEED_PAGE/post.inc.php" method='POST' enctype="multipart/form-data">
                    <div class="post-form-input">
                        <!-- User avatar here, needs to be fetched -->
                        <?php show_current_user_avatar_for_post_form($pdo); ?>


                        <textarea rows="2" placeholder="What's on your mind?" name="post_text"></textarea>
                    </div>
                    <div class="post-form-actions">
                        <label for="post_image_input">
                            <!-- Icon for image upload -->
                            📷 Photo/Video
                            <input type="file" accept="image/*" name="post_image" id="post_image_input">
                        </label>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </div>
                    <?php upload_error_occurred() ?>
                </form>
            </div>

            <!-- Feed display area -->
            <?php show_new_feed($pdo) ?>
        </div>

        <aside class="sidebar" id="sidebar">
            <!-- Mobile nav links -->
            <div class="nav-links-mobile">
                <a href="newsfeed.php">Home</a>
                <a href="profile.php">Profile</a>
                <a href="#">Notifications</a>
                <a href="logout.php">Logout</a>
            </div>

            

            <div class="card sidebar-section">
                <h3>Suggested for you</h3>
                <div class="suggestions-list">
                    <?php show_new_suggession_form_database($pdo); ?>
                </div>


               

            </div>
        </aside>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
        }
    </script>
</body>

</html>