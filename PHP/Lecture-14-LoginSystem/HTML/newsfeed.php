<?php
    require_once "../includes/config_session.inc.php";
    $pdo = require_once "../includes/dbh.inc.php";;
    require_once "../includes/NEWSFEED_PAGE/newsfeed_view.php";
    require_once "../includes/NEWSFEED_PAGE/post_view.inc.php";
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Responsive News Feed</title>
    <style>
        /* General Reset & Base */
        * {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background: #F3F4F6;
        }

        /* Navbar */
        .navbar {
            background: #1E3A8A;
            padding: 1rem;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-links {
            display: flex;
            gap: 1.5rem;
        }

        .navbar-links a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
        }

        .hamburger {
            display: none;
            background: none;
            border: none;
            color: #fff;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Layout */
        .container {
            display: flex;
            max-width: 1200px;
            margin: 1.5rem auto;
            gap: 1.5rem;
            padding: 0 1rem;
        }

        .main-content {
            flex: 2;
        }

        .sidebar {
            flex: 1;
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 300px;
            transition: transform 0.3s ease-in-out;
        }

        /* Sidebar content */
        .sidebar .nav-links-mobile {
            display: none;
            flex-direction: column;
            margin-bottom: 2rem;
        }

        .sidebar .nav-links-mobile a {
            color: #1E3A8A;
            text-decoration: none;
            margin: 0.25rem 0;
            font-weight: bold;
        }

        .user-info, .friend-suggestions {
            margin-bottom: 1.5rem;
        }

        .user-info img {
            width: 60px;
            border-radius: 50%;
            margin-bottom: 0.5rem;
            img {
                padding-top: 1rem;
            }
            
            p{
                padding-top: 1rem;
            }
            
        }

        .suggestion {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .suggestion img {
            width: 40px;
            border-radius: 50%;
            margin-right: 0.5rem;
        }

        .suggestion button {
            background: #3B82F6;
            color: #fff;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            cursor: pointer;
        }

        /* Post form & post */
        .post-form,
        .post {
            background: #fff;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        .post-form textarea {
            width: 100%;
            padding: 0.75rem;
            resize: vertical;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .post-form button {
            margin-top: 0.75rem;
            background: #3B82F6;
            color: #fff;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
        }

        .post-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .post-header img {
            width: 40px;
            border-radius: 50%;
        }

        .post .actions button {
            background: none;
            border: none;
            color: #1E3A8A;
            font-weight: bold;
            cursor: pointer;
            margin-right: 1rem;
        }

        .success-message {
            width: 85%;
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
            background-color: #d0f0c0; /* soft light green background */
            font-family: 'Times New Roman', Times, serif;
        }

        .success-message h3 {
            color: #2e7d32; /* dark green text */
            margin: 0;
        }

        .success-message p {
            margin-top: 5px;
            color: #1b5e20; /* even darker for better contrast */
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .navbar-links {
                display: none;
            }

            .hamburger {
                display: block;
            }

            .sidebar {
                position: fixed;
                top: 0;
                right: 0;
                height: 100%;
                width: 260px;
                transform: translateX(100%);
                background: #fff;
                z-index: 1001;
                overflow-y: auto;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar .nav-links-mobile {
                display: flex;
            }
        }

        @media (min-width: 769px) {
            .sidebar .nav-links-mobile {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="navbar-links">
        <a href="newsfeed.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="#">Notifications</a>
        <a href="logout.php">Logout</a>
    </div>
    <button class="hamburger" onclick="toggleSidebar()">☰</button>
</nav>

<!-- Main Container -->
<div class="container">
    <div class="main-content">
        <!-- Create a Post -->
        <div class="post-form">
            <form action="../includes/NEWSFEED_PAGE/post.inc.php" method='POST' enctype="multipart/form-data">

                <!-- Status area -->
                <label for="Status">
                    <textarea rows="4" placeholder="What's on your mind?" name="post_text" >This is a sample Post</textarea>
                </label>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                    <!-- Image upload button -->
                    <label for="Uploading Image">
                        <input type="file" accept="image/*" name="post_image">
                    </label>

                    <button type="submit">Post</button>
                </div>
                <?php
                    upload_error_occurred()
                ?>





            </form>
        </div>

        <!-- News Feed -->
        <div class="post" >
            <div class="post-header">
                <img src="avatar-placeholder.jpg" alt="Avatar" />
                <h3>Username</h3>
            </div>
            <p>This is a sample post text with some image.</p>
            <img src="sample-image.jpg" alt="Sample" style="width:100%; border-radius:8px;" />
            <div class="actions">
                <button>Like (3)</button>
                <button>Comment (1)</button>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <!-- Mobile-only nav links -->
        <div class="nav-links-mobile">
            <a href="newsfeed.php">Home</a>
            <a href="profile.php">Profile</a>
            <a href="#">Notifications</a>
            <a href="#">Logout</a>
        </div>



        <!-- User Information-->
        <div class="user-info">

        <?php
        
            show_user_information( $pdo );
        
        ?>    
            
            
            
            
        </div>


        <!-- Suggested Friends -->

<!--        <div class="friend-suggestions">-->
<!--            <h3>Suggested Friends</h3>-->
<!--            <div class="suggestion">-->
<!--                <img src="friend-avatar.jpg" alt="Friend" />-->
<!--                <div>-->
<!--                    <p>Jane</p>-->
<!--                    <button>Add</button>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="suggestion">-->
<!--                <img src="friend-avatar2.jpg" alt="Friend" />-->
<!--                <div>-->
<!--                    <p>Mike</p>-->
<!--                    <button>Add</button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->





        <?php
            show_new_suggession_form_database($pdo);
        ?>





    </aside>
</div>

<!-- Script -->
<script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("active");
    }
</script>
</body>
</html>
















