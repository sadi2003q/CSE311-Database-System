<?php
    require_once "../includes/config_session.inc.php";
    require_once "../includes/LOGIN_PAGE/login_view.inc.php";
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Minimal Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        body {
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 320px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            padding: 0.75rem;
            margin-bottom: 1.2rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 0.95rem;
        }

        button, a {
            padding: 0.75rem;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.95rem;
            
            display: flex;
            align-content: center;
            justify-content: center;
            margin-top: 1rem;
            text-decoration: none;
            font-weight: bold;
            font-family: "Times New Roman", Times, serif;
        }

        button:hover, a:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Login</h2>
    <form action="../includes/LOGIN_PAGE/login.inc.php" method="POST">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" />

        <label for="password">Password</label>
        <input type="password" id="password" name="password" />

        <button type="submit">Login</button>
        <a href="login_signup.php" style="background-color: gray;">GO to Sign in</a>
    </form>
    <div style="margin-top: 1rem;">
        <?php

        check_login_status()
        
        ?>
    </div>
    
</div>
</body>
</html>