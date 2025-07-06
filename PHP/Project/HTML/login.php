<?php
    require_once "../includes/config_session.inc.php";
    require_once "../includes/LOGIN_PAGE/login_view.inc.php";
?>

<!-- 

    This page will allow user to login with existing email and password
    Check for some simple constrain like for username and password

-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>UDIA Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }
        body {
            background-color: #f0f2f5;
            color: #1c1e21;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            display: flex;
            max-width: 980px;
            width: 100%;
            align-items: flex-start;
            gap: 60px;
            flex-wrap: wrap;
        }

        .left-section {
            flex: 1;
            min-width: 300px;
            padding-top: 20px;
        }

        .logo {
            font-size: 56px;
            font-weight: 700;
            letter-spacing: -2px;
            margin-bottom: 20px;
            background: linear-gradient(45deg, #1877f2, #42b72a, #ff4081);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: gradientShift 3s ease infinite;
            text-align: left;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .inspiring-text {
            font-size: 28px;
            line-height: 32px;
            color: #606770;
            max-width: 500px;
        }
        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1), 0 8px 16px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            min-width: 300px;
            text-align: center;
        }

        .login-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1c1e21;
        }
        .logo h2 {
            color: #FF6B6B;
            font-size: 2.5rem;
            font-weight: 700;
            animation: logoAnimation 4s infinite ease-in-out;
        }
        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="password"] {
            padding: 14px 16px;
            margin-bottom: 15px;
            border: 1px solid #dddfe2;
            border-radius: 6px;
            font-size: 17px;
            background-color: #fff;
            color: #1c1e21;
        }

        input:focus {
            outline: none;
            border-color: #1877f2;
            box-shadow: 0 0 0 2px #e7f3ff;
        }

        .login-btn {
            padding: 14px;
            background-color: #1877f2;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .login-btn:hover {
            background-color: #166fe5;
        }

        .signup-link {
            padding: 14px;
            background-color: #42b72a;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 17px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            display: block;
        }

        .signup-link:hover {
            background-color: #36a420;
        }

        .divider {
            border-top: 1px solid #dddfe2;
            margin: 20px 0;
        }

        .error-message {
            color: #f02849;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>



<body>
<div class="container">

    <!-- 

        Simple Message with Logo

    -->
    <div class="left-section">
        <div class="logo">UDIA</div>
        <h2 class="inspiring-text">Connect with friends and the world around you ...</h2>
    </div>


    <!-- 
        main login part which connecte with login.inc.php and then
        -> check for if all fields are empty or not
        -> if username or password not exist on the database
        -> verify username and password
        -> Button for login
        -> takes to create account page
    -->
    <div class="login-container">
        <h2 class="login-title"> Sign In </h2>
        <form action="../includes/LOGIN_PAGE/login.inc.php" method="POST">
            <input type="text" id="username" name="username" placeholder="Username" value="sadi"/>
            <input type="password" id="password" name="password" placeholder="Password" value="1234" />
            <button type="submit" class="login-btn">Log In</button>
            <div class="divider"></div>
            <a href="login_signup.php" class="signup-link">Create new account</a>
        </form>




        <!-- This portion will active if something is wrong found or error found -->
        <div class="error-message">
            <?php
                check_login_status();
            ?>
        </div>
    </div>
</div>
</body>
</html>