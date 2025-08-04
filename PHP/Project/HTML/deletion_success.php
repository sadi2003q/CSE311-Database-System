<?php
// deletion_success.php
require_once '../includes/SETTING_PAGE/setting.model.inc.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Account Deletion Requested</title>
    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
        }
        .success-message {
            background-color: #f0fdf4;
            color: #166534;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }
        .action-button {
            background-color: #3B82F6;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            display: inline-block;
            font-size: 1rem;
            transition: background-color 0.3s;
        }
        .action-button:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-message">
            ✅ Your account deletion request has been submitted successfully.
            <p>Our team will process your request shortly.</p>
        </div>
        <a href="login_signup.php" class="action-button">
            Go to Signup Page
        </a>
    </div>
</body>
</html>