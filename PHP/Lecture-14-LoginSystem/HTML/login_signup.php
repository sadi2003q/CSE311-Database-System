<?php 
require_once "../includes/signup_view.inc.php";
require_once "../includes/config_session.inc.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign Up - SecureAuth</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-y: auto;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                    radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                    radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);
            pointer-events: none;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            display: flex;
            gap: 40px;
            max-width: 1000px;
            width: 100%;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 50px;
            box-shadow:
                    0 25px 50px rgba(0, 0, 0, 0.1),
                    inset 0 1px 0 rgba(255, 255, 255, 0.2);
            flex: 1;
            min-width: 350px;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg,
            rgba(255, 255, 255, 0.1) 0%,
            rgba(255, 255, 255, 0.05) 50%,
            rgba(255, 255, 255, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
            pointer-events: none;
        }

        .card:hover::before {
            opacity: 1;
        }

        .card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow:
                    0 35px 70px rgba(0, 0, 0, 0.15),
                    0 15px 35px rgba(102, 126, 234, 0.1),
                    inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .card-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .card-title {
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(135deg, #f9f871 0%, #a1f0ff 50%, #ffc8dd 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
            animation: textShimmer 3s ease-in-out infinite alternate;
        }

        @keyframes textShimmer {
            0% { filter: hue-rotate(0deg); }
            100% { filter: hue-rotate(30deg); }
        }

        .card-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 16px;
            font-weight: 300;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
            font-size: 15px;
        }

        .form-input {
            width: 100%;
            padding: 18px 20px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            font-size: 16px;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: white;
            position: relative;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.15);
            box-shadow:
                    0 0 0 4px rgba(102, 126, 234, 0.2),
                    0 8px 25px rgba(102, 126, 234, 0.15);
            transform: translateY(-2px);
        }

        .form-button {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 200% 200%;
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .form-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .form-button:hover::before {
            left: 100%;
        }

        .form-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
            background-position: right center;
        }

        .form-button:active {
            transform: translateY(-1px);
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            font-weight: 500;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            z-index: 1;
        }

        .divider span {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 8px 20px;
            border-radius: 20px;
            position: relative;
            z-index: 2;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .footer-text {
            text-align: center;
            margin-top: 25px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 13px;
            line-height: 1.4;
        }

        .required {
            color: #ff6b9d;
            filter: drop-shadow(0 0 5px rgba(255, 107, 157, 0.5));
        }
    </style>
</head>
<body>
<div style="height: 800px">
    <div class="container">
        <!-- Login Card -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Welcome Back</h2>
                <p class="card-subtitle">Sign in to your account</p>
            </div>
            <!--        Here I have to add the login form-->
            <form action="../includes/login.inc.php" method="POST">
                <div class="form-group">
                    <label for="login-username" class="form-label">Username <span class="required">*</span></label>
                    <input
                            type="text"
                            id="login-username"
                            name="username"
                            class="form-input"
                            placeholder="Enter your username"
                            required
                    />
                </div>

                <div class="form-group">
                    <label for="login-password" class="form-label">Password <span class="required">*</span></label>
                    <input
                            type="password"
                            id="login-password"
                            name="password"
                            class="form-input"
                            placeholder="Enter your password"
                            required
                    />
                </div>

                <button type="submit" class="form-button">Sign In</button>
            </form>

            <div class="divider">
                <span>Secure Login</span>
            </div>

            <div class="footer-text">
                Protected by advanced encryption
            </div>
        </div>

        <!-- SignUp Card -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Create Account</h2>
                <p class="card-subtitle">Join us today</p>
            </div>


            <!--        Here is that something that I have to do-->
            <form action="../includes/signup.inc.php" method="POST">
                <div class="form-group">
                    <label for="signup-email" class="form-label">Email Address <span class="required">*</span></label>
                    <input
                            type="email"
                            id="signup-email"
                            name="email"
                            class="form-input"
                            placeholder="Enter your email"
                            
                    />
                </div>

                <div class="form-group">
                    <label for="signup-username" class="form-label">Username <span class="required">*</span></label>
                    <input
                            type="text"
                            id="signup-username"
                            name="username"
                            class="form-input"
                            placeholder="Choose a username"
                            
                    />
                </div>

                <div class="form-group">
                    <label for="signup-password" class="form-label">Password <span class="required">*</span></label>
                    <input
                            type="password"
                            id="signup-password"
                            name="password"
                            class="form-input"
                            placeholder="Create a password"

                    />
                </div>

                <button type="submit" class="form-button">Create Account</button>
            </form>

            <div class="divider">
                <span>Quick & Easy</span>
            </div>

            <div class="footer-text">
                By signing up, you agree to our terms of service
            </div>
        </div>






    </div>

    <div style="margin: 10px; width: 100% height: 400px; 
    color: white; font-size: 1.3rem; font-family: 'Times New Roman', Times, serif; 
    font-weight: 600; background-color: #ff6b6b; border-radius: 10px;  padding: 10px;  "
    >
        <?php
             check_signup_errors()
        ?>
    </div>
</div>




</body>
</html>