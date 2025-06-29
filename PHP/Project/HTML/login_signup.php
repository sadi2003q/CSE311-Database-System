<?php
require_once "../includes/SIGNUP_PAGE/signup_view.inc.php";
require_once "../includes/config_session.inc.php";
?>


<!-- 

    This page Allow user to Signup with Social Media
    -> username
    -> age
    -> email
    -> password
    -> dob


    Check of the validaiton 
    -> if duplicate username exist
    -> if email is valid and it exist in the database
    -> if given age is over 10 or not

-->





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook Style Signup</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Helvetica, Arial, sans-serif;
        }

        body {
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .signup-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 100%;
            max-width: 430px;
        }

        .signup-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .signup-title {
            font-size: 28px;
            font-weight: bold;
            color: #1c1e21;
        }

        .signup-subtitle {
            font-size: 15px;
            color: #606770;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccd0d5;
            border-radius: 6px;
            font-size: 15px;
            background-color: #f5f6f7;
        }

        .form-input:focus {
            outline: none;
            border-color: #1877f2;
            background-color: white;
        }

        select.form-input {
            background-color: white;
        }

        .form-button {
            width: 100%;
            padding: 12px;
            background: #42b72a;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        .form-button:hover {
            background: #36a420;
        }

        .link_signup {
            display: block;
            text-align: center;
            background-color: #e4e6eb;
            color: #050505;
            text-decoration: none;
            padding: 10px;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 15px;
            font-size: 14px;
        }

        .link_signup:hover {
            background-color: #d8dadf;
        }

        .error-message {
            color: #d93025;
            font-size: 14px;
        }

        .success-message {
            color: #34a853;
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }

        #message-area {
            margin-top: 20px;
            text-align: center;
        }
        
        .form-input::placeholder {
            color: #8d949e;
            font-size: 14px;
        }

    </style>
</head>



<body>
<div class="signup-container">


    <!-- 
        Some Simple Message
    -->
    <div class="signup-header">
        <h2 class="signup-title">Create a new account</h2>
        <p class="signup-subtitle">It’s quick and easy.</p>
    </div>




    <!-- 
        connect with signup.inc.php file and show user the field for siging up    
        button for sign up
        and go to login page if they already have one
    -->
    <form action="../includes/SIGNUP_PAGE/signup.inc.php" method="POST">
        <?php signup_input(); ?>
        <button type="submit" class="form-button">Sign Up</button>
        <a href="login.php" class="link_signup">Already have an account?</a>
    </form>





    <!-- 
        This Part will only activate if there is showing some sort of error with given input
    -->
    <div id="message-area">
        <?php check_signup_errors(); ?>
    </div>





</div>





</body>
</html>