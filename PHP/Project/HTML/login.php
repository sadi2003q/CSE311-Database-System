<?php
    require_once "../includes/config_session.inc.php";
    require_once "../includes/LOGIN_PAGE/login_view.inc.php";
?>
<<<<<<< HEAD
<!-- Main function -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UDIA</title>
=======

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
>>>>>>> sadi_x
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }
        body {
<<<<<<< HEAD
            background: linear-gradient(135deg, #D9ED92, #B5E48C, #99D98C);
=======
            background-color: #f0f2f5;
            color: #1c1e21;
>>>>>>> sadi_x
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
<<<<<<< HEAD
            padding: 1rem;
        }
        .container {
            display: flex;
            max-width: 900px;
            width: 100%;
            align-items: center;
            gap: 2rem;
            background-color: rgba(36, 37, 38, 0.9);
            border-radius: 12px;
            padding: 2rem;
            border: 1px solid #3E4042;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }
        .image-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            text-align: left;
        }
        .udia-logo {
            font-size: 5rem;
            font-weight: 700;
            color: #FF6B6B;
            text-transform: uppercase;
            animation: logoAnimation 4s infinite ease-in-out;
        }
        @keyframes logoAnimation {
            0%, 100% {
                color: #FF6B6B;
            }
            50% {
                color: #FFD93D;
            }
        }
        .image-section h3 {
            color: #E4E6EB;
            font-size: 1.6rem; /* Slightly reduced for better wrapping */
            margin-top: 1rem;
            font-weight: 500;
            max-width: 230px; /* Fine-tuned for two-line wrap */
            line-height: 1.3; /* Adjusted for better spacing */
        }
        .login-section {
            flex: 1;
            max-width: 396px;
=======
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
>>>>>>> sadi_x
        }
        .login-container {
<<<<<<< HEAD
            background-color: #242526;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2), 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 100%;
        }
        .logo {
            text-align: center;
            margin-bottom: 1.5rem;
=======
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
>>>>>>> sadi_x
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
<<<<<<< HEAD
        label {
            margin-bottom: 0.25rem;/*bottom margin*/
            font-size: 0.9rem;
            color: #E4E6EB;
        }
        input[type="text"],
        input[type="password"] {
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #3E4042;
            border-radius: 6px;
            font-size: 1rem;
            background-color: #3A3B3C;
            color: #E4E6EB;
        }
        input:focus {
            outline: none;
            border-color: #4ECDC4;
            box-shadow: 0 0 0 2px rgba(78, 205, 196, 0.3);
        }
        button {
            padding: 0.75rem;
            background-color: #4ECDC4;
            color: #FFFFFF;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            transition: background-color 0.2s;
        }
        button:hover {
            background-color: #3DA8A1;
        }
        a {
            padding: 0.75rem;
            background-color: #6C5CE7;
            color: #FFFFFF;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            justify-content: center;
            margin-top: 1rem;
            transition: background-color 0.2s;
        }
        a:hover {
            background-color: #5343C2;
        }
        .error {
            text-align: center;
            margin-top: 1rem;
            color: #B0B3B8;
            font-size: 0.9rem;
        }
        /*check*/
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            text-align: center;
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #3E4042;
        }
        .divider span {
            margin: 0 1rem;
            color: #B0B3B8;
            font-size: 0.9rem;
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                gap: 1rem;
                padding: 1.5rem;
            }
            .login-section {
                max-width: 100%;
            }
            .login-container {
                padding: 1.5rem;
            }
            .logo h2 {
                font-size: 2rem;
            }
            button, a {
                font-size: 1rem;
            }
            .udia-logo {
                font-size: 3.5rem;
            }
            .image-section h3 {
                font-size: 1.3rem; /* Slightly reduced for mobile */
                max-width: 200px; /* Fine-tuned for mobile */
            }
=======

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
>>>>>>> sadi_x
        }
    </style>
</head>



<body>
<<<<<<< HEAD
    <div class="container">
        <div class="image-section">
            <div class="udia-logo">UDIA</div>
            <h3>Your story has the power to inspire someone else's breakthrough</h3>
        </div>
        <div class="login-section">
            <div class="login-container">
                <div class="logo">
                    <h2>Welcome</h2>
                </div>
                <form action="../includes/LOGIN_PAGE/login.inc.php" method="POST">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="sadi"/>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" value="1234" />

                    <button type="submit">Log In</button>
                </form>
                <div class="divider">
                    <span>or</span>
                </div>
                <a href="login_signup.php">Create new account</a>
                <div class="error">
                    <?php
                        check_login_status();
                    ?>
                </div>
            </div>
        </div>
    </div>
=======
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
>>>>>>> sadi_x
</body>
</html>