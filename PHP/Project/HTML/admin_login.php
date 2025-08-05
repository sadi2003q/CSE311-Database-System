<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/ADMIN_PANEL/admin_view.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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
            background-color: #1a1a1a;
        }
        .login-container {
            background: #2d2d2d;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            color: #fff;
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-title {
            font-size: 24px;
            margin-bottom: 10px;
            color: #4ECDC4;
        }
        .login-subtitle {
            color: #aaa;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #ddd;
            font-weight: 500;
        }
        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #444;
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s;
            background-color: #3a3a3a;
            color: #fff;
        }
        .form-input:focus {
            outline: none;
            border-color: #4ECDC4;
        }
        .form-button {
            width: 100%;
            padding: 12px;
            background: #4ECDC4;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        .form-button:hover {
            background: #3da8a1;
        }
        .error-message {
            color: #ff6b6b;
            font-size: 14px;
            margin-top: 5px;
        }
        .message {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }
        .error {
            color: #ff6b6b;
        }
        .success {
            color: #4CAF50;
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-header">
        <h2 class="login-title">Admin Panel</h2>
        <p class="login-subtitle">Restricted access</p>
    </div>

   <form action="../includes/ADMIN_PANEL/admin_login.inc.php" method="POST">
        <div class="form-group">
            <label for="username" class="form-label">Admin Username</label>
            <input
                type="text"
                id="username"
                name="username"
                class="form-input"
                value="admin"
                placeholder="Enter admin username"
                required
            >
        </div>
        
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-input"
                placeholder="Enter password"
                value="password"
                required
            >
        </div>
        
        <button type="submit" class="form-button">Login</button>
    </form>

    <div class="message">
        <?php
         check_login_status();
        ?>
    </div>
</div>
</body>
</html>