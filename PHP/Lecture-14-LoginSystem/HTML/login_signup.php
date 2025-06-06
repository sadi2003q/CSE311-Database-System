<?php

require_once "../includes/signup_view.inc.php";
require_once "../includes/config_session.inc.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Signup Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .signup-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
        }

        .signup-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .signup-title {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .signup-subtitle {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-button {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .form-button:hover {
            background: #5a6fd1;
        }

        .error-message {
            color: #ff6b6b;
            font-size: 14px;
            margin-top: 5px;
        }

        .success-message {
            color: #4CAF50;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="signup-container">
    <div class="signup-header">
        <h2 class="signup-title">Create Account</h2>
        <p class="signup-subtitle">Join us today</p>
    </div>

    <form action="../includes/signup.inc.php" method="POST">
<!--        <div class="form-group">-->
<!--            <label for="email" class="form-label">Email Address</label>-->
<!--            <input-->
<!--                    type="email"-->
<!--                    id="email"-->
<!--                    name="email"-->
<!--                    class="form-input"-->
<!--                    placeholder="Enter your email"-->
<!---->
<!--            >-->
<!--        </div>-->
<!---->
<!--        <div class="form-group">-->
<!--            <label for="username" class="form-label">Username</label>-->
<!--            <input-->
<!--                    type="text"-->
<!--                    id="username"-->
<!--                    name="username"-->
<!--                    class="form-input"-->
<!--                    placeholder="Choose a username"-->
<!---->
<!--            >-->
<!--        </div>-->
<!---->
<!--        <div class="form-group">-->
<!--            <label for="password" class="form-label">Password</label>-->
<!--            <input-->
<!--                    type="password"-->
<!--                    id="password"-->
<!--                    name="password"-->
<!--                    class="form-input"-->
<!--                    placeholder="Create a password"-->
<!---->
<!--            >-->
<!--        </div>-->
        <?php
        signup_input();

        ?>
        <button type="submit" class="form-button">Sign Up</button>
    </form>

    <!-- This div will display any error messages -->
    <div id="message-area" style="margin-top: 20px;">
       <?php
        check_signup_errors();

       ?>
    </div>
</div>
</body>
</html>