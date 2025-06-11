<?php
    require_once '../includes/config_session.inc.php';
    $pdo = require_once '../includes/dbh.inc.php';
    require_once '../includes/LOGOUT_PAGE/logout_view.inc.php';
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - Social Media</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            background-color: #F3F4F6;
        }
        .navbar {
            background-color: #1E3A8A;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar-links {
            display: flex;
            align-items: center;
        }
        .navbar-links a {
            color: #FFFFFF;
            text-decoration: none;
            margin: 0 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            transition: color 0.2s;
        }
        .navbar-links a:hover {
            color: #3B82F6;
        }
        .hamburger {
            display: none;
            font-size: 1.5rem;
            color: #FFFFFF;
            background: none;
            border: none;
            cursor: pointer;
        }
        .container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .logout-box {
            background-color: #FFFFFF;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .logout-box h1 {
            color: #111827;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .logout-box p {
            color: #6B7280;
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }
        .logout-box form {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }
        .logout-box button {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .logout-box button[type="submit"] {
            background-color: #3B82F6;
            color: #FFFFFF;
        }
        .logout-box button[type="submit"]:hover {
            background-color: #1E3A8A;
        }
        .logout-box button.cancel {
            background-color: #D1D5DB;
            color: #111827;
        }
        .logout-box button.cancel:hover {
            background-color: #9CA3AF;
        }

        .error-message {
            width: 100%;
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
            background-color: #f8d7da; /* soft light green background */
            font-family: 'Times New Roman', Times, serif;
            text-align: start;

        }

        .error-message h3 {
            color: #c62828; /* dark green text */
            margin: 0;
        }

        .error-message p {
            margin-top: 5px;
            color: #b71c1c; /* even darker for better contrast */
        }


        @media (max-width: 768px) {
            .navbar-links {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 60px;
                left: 0;
                right: 0;
                background-color: #1E3A8A;
                padding: 1rem;
                z-index: 999;
            }
            .navbar-links.active {
                display: flex;
            }
            .navbar-links a {
                margin: 0.5rem 0;
                text-align: center;
            }
            .hamburger {
                display: block;
            }
            .container {
                margin: 1rem auto;
            }
        }
        @media (min-width: 769px) {
            .navbar-links {
                display: flex !important;
            }
        }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="navbar-links">
        <a href="newsfeed.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="notifications.html">Notifications</a>

    </div>
    <button class="hamburger" onclick="toggleMenu()">☰</button>
</nav>
<div class="container">
    <div class="logout-box">
        <h1>Log Out</h1>
        <p>Are you sure you want to log out?</p>
        <form action="../includes/LOGOUT_PAGE/logout.inc.php" method="POST">
            <button type="submit" name="button_logout">Log Out</button>
            <button type="button" class="cancel" onclick="window.location.href='newsfeed.php'">Cancel</button>
        </form>

<!--        <div class="error-message" style="padding-top: 20px;">-->
<!--            <h3 style="text-align: start">Something is wrong</h3>-->
<!--            <p style="padding-top: 5px;">Something is now working. Cannot logout now, PLease try again later</p>-->
<!--        </div>-->
        <?php
            show_error_while_logging_out();
        ?>

    </div>
</div>
<script>
    function toggleMenu() {
        document.querySelector('.navbar-links').classList.toggle('active');
    }
</script>
</body>
</html>