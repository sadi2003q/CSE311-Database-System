<?php
require_once "../includes/config_session.inc.php";
$pdo = require_once "../includes/dbh.inc.php";
require_once "../includes/COMMENT_PAGE/comment.view.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
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

        .content {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @media (min-width: 768px) {
            .content {
                grid-template-columns: 2fr 1fr;
            }
        }

        .post-column {
            background-color: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            height: calc(100vh - 150px);
            overflow-y: auto;
        }

        .interaction-column {
            background-color: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            height: calc(100vh - 150px);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        /* Post */
        .post {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--light-gray);
            padding-bottom: 1.5rem;
        }

        .post:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
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
            color: var(--gray);
        }

        .post-content .post-text {
            margin-bottom: 1rem;
            line-height: 1.5;
            font-size: 1.1rem;
        }

        .post-content .post-text.bold-status {
            font-weight: 600;
        }

        .post-content .post-image {
            max-width: 100%;
            height: auto;
            max-height: 400px;
            border-radius: var(--border-radius);
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .post-actions {
            display: flex;
            justify-content: space-between;
            padding-top: 0.5rem;
            border-top: 1px solid var(--light-gray);
            gap: 0.5rem;
        }

        .action-btn {
            background: none;
            border: none;
            color: var(--gray);
            font-weight: 600;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 6px;
            transition: background-color 0.2s ease;
            width: 100%;
            text-align: center;
        }

        .action-btn:hover {
            background-color: var(--light-gray);
        }

        .action-btn.reacted {
            color: var(--primary);
            font-weight: 700;
        }

        .reactions-section {
            background-color: var(--light-gray);
            padding: 1rem;
            border-radius: var(--border-radius);
        }

        .reactions-title {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .comments-section {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .comments-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .comment-form {
            display: flex;
            gap: 0.5rem;
            margin-top: auto;
        }

        .comment-input {
            flex-grow: 1;
            padding: 0.75rem;
            border: 1px solid var(--light-gray);
            border-radius: var(--border-radius);
            resize: none;
        }

        .comment-submit {
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            padding: 0 1rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .comment-submit:hover {
            background-color: var(--primary-dark);
        }

        @media (max-width: 768px) {
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
            
            .post-column,
            .interaction-column {
                height: auto;
                max-height: none;
                overflow-y: visible;
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
        <div>
            <a href="newsfeed.php"><i class="fas fa-home"></i> Home</a>
            <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
            <a href="#"><i class="fas fa-bell"></i> Notifications</a>
        </div>
    </nav>

    <div class="content">
        <div class="post-column">
            <?php show_this_post($pdo) ?>
        </div>
        
        <div class="interaction-column">
            <div class="reactions-section">
                <h3 class="reactions-title">Reactions</h3>
                <!-- Reactions content will go here -->
                <p>People who reacted to this post will appear here.</p>
            </div>
            
            <div class="comments-section">
                <h3 class="comments-title">Comments</h3>
                <!-- Comments will go here -->
                <p>Comments on this post will appear here.</p>
                
                <form class="comment-form">
                    <textarea id="commentInput" class="comment-input" placeholder="Write a comment..."></textarea>
                    <button type="submit" class="comment-submit"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
    </div>








    <script>
        
        document.addEventListener("DOMContentLoaded", function () {
            const commentButton = document.querySelector(".focus-comment-btn");
            const commentInput = document.getElementById("commentInput");

            if (commentButton && commentInput) {
                commentButton.addEventListener("click", function () {
                    commentInput.focus();
                });
            }
        });
        
    </script>

</body>
</html>