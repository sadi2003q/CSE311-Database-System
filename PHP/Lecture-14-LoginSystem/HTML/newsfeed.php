<?php
    require_once "../includes/config_session.inc.php";
    $pdo = require_once "../includes/dbh.inc.php";;
    require_once "../includes/NEWSFEED_PAGE/newsfeed_view.php";
?>


<!--<!DOCTYPE html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <title>Title</title>-->
<!---->
<!--    <style>-->
<!---->
<!--        .container {-->
<!--            width: 100%;-->
<!--            height: 500px;-->
<!--            border: 1px solid black;-->
<!--            display: flex;-->
<!--            justify-content: center;-->
<!---->
<!--            .content {-->
<!--                margin: 10px;-->
<!---->
<!---->
<!--                h2{-->
<!--                    text-decoration: underline;-->
<!--                }-->
<!--            }-->
<!---->
<!--        }-->
<!---->
<!---->
<!--    </style>-->
<!---->
<!--</head>-->
<!--<body>-->
<!---->
<!---->
<!--<div class="container">-->
<!--    <div class="content">-->
<!--        <h2>User Information</h2>-->
<!---->
<!--        <div>-->
<!--            <p>   Name: </p>-->
<!--            <p>  Email: </p>-->
<!--            <p>  Phone: </p>-->
<!--            <p>Address: </p>-->
<!--        </div>-->
<!---->
<!--        --><?php
//
//        show_user_information( $pdo );;
//
//        ?>
<!---->
<!---->
<!--    </div>-->
<!--</div>-->
<!---->
<!---->
<!--</body>-->
<!--</html>-->



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
        <a href="#">Home</a>
        <a href="#">Profile</a>
        <a href="#">Notifications</a>
        <a href="#">Logout</a>
    </div>
    <button class="hamburger" onclick="toggleSidebar()">☰</button>
</nav>

<!-- Main Container -->
<div class="container">
    <div class="main-content">
        <!-- Post Form -->
        <div class="post-form">
            <form>
                <label>
                    <textarea rows="4" placeholder="What's on your mind?"></textarea>
                </label>
                <button type="submit">Post</button>
            </form>
        </div>

        <!-- A Post -->
        <div class="post">
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
            <a href="#">Home</a>
            <a href="#">Profile</a>
            <a href="#">Notifications</a>
            <a href="#">Logout</a>
        </div>

        <div class="user-info">
<!--            <p style="padding-top: 1rem;"><strong>Username:</strong> JohnDoe</p>-->
<!--            <p style="padding-top: 1rem;"><strong>Email:</strong> john@example.com</p>-->
        <?php
        
            show_user_information( $pdo );
        
        ?>    
            
            
            
            
        </div>

        <div class="friend-suggestions">
            <h3>Suggested Friends</h3>
            <div class="suggestion">
                <img src="friend-avatar.jpg" alt="Friend" />
                <div>
                    <p>Jane</p>
                    <button>Add</button>
                </div>
            </div>
            <div class="suggestion">
                <img src="friend-avatar2.jpg" alt="Friend" />
                <div>
                    <p>Mike</p>
                    <button>Add</button>
                </div>
            </div>
        </div>
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
















