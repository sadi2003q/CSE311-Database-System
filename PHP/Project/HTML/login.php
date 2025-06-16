<?php
    require_once "../includes/config_session.inc.php";
    require_once "../includes/LOGIN_PAGE/login_view.inc.php";
?>
<!-- Main function -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UDIA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #D9ED92, #B5E48C, #99D98C);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
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
        }
        .login-container {
            background-color: #242526;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2), 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 100%;
        }
        .logo {
            text-align: center;
            margin-bottom: 1.5rem;
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
        label {
            margin-bottom: 0.25rem;
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
        }
    </style>
</head>
<body>
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
</body>
</html>