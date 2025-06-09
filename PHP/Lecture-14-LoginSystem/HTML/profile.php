<?php
require_once "../includes/config_session.inc.php";
$pdo = require_once "../includes/dbh.inc.php";
require_once "../includes/PROFILE_PAGE/profile_view.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Social Media</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            background-color: #F3F4F6;
        }
        .navbar {
            background-color: #1E3A8A;
            padding: 1rem;
        }
        .navbar a {
            color: #FFFFFF;
            text-decoration: none;
            margin: 0 1rem;
            font-size: 1rem;
        }
        .navbar a:hover {
            color: #3B82F6;
        }
        .container {
            max-width: 800px;
            margin: 2rem auto;
        }
        .profile-header {
            background-color: #FFFFFF;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            text-align: center;
        }
        .profile-header h1 {
            color: #111827;
            margin-bottom: 0.5rem;
        }
        .profile-header p {
            color: #6B7280;
        }
        .profile-form {
            background-color: #FFFFFF;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            color: #111827;
            margin-bottom: 0.5rem;
        }
        input, select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #D1D5DB;
            border-radius: 4px;
            font-size: 1rem;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        button {
            padding: 0.75rem;
            background-color: #3B82F6;
            color: #FFFFFF;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        button:hover {
            background-color: #1E3A8A;
        }
        .post {
            background-color: #FFFFFF;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }
        .post h3 {
            color: #111827;
            margin-bottom: 0.5rem;
        }
        .post p {
            color: #111827;
            margin-bottom: 0.5rem;
        }
        .post .meta {
            color: #6B7280;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <!--Navigation Part-->
    <nav class="navbar">
    <a href="newsfeed.php">Home</a>
    <a href="profile.php">Profile</a>
    <a href="#">Notifications</a>
    <a href="logout.php">Logout</a>
</nav>
<div class="container">


    <!--  Current Profile Information  -->
    <div class="profile-header">

<!--        <p>Email: user@example.com | Age: 25 | Sex: Male</p>-->
        <?php

            show_user_information_profile_view();

        ?>
    </div>



    <!--  Profile Update Form  -->
    <div class="profile-form">
        <form action="../includes/PROFILE_PAGE/profile.inc.php" method="POST">

            <div class="form-group">
                <label for="username">Username</label>
                <?php
                    $username = $_SESSION['username'];
                    echo '<input type="text" id="username" name="username" value="'. $username .  '" >';
                ?>
<!--                <input type="text" id="username" name="username" value="Username">-->
            </div>

            <div class="form-group">
                <label for="email">Email</label>

                <?php
                $email = $_SESSION['email'];
                echo '<input type="email" id="email" name="email" value="'. $email .  '" >';
                ?>

<!--                <input type="email" id="email" name="email" value="user@example.com">-->
            </div>

            <div class="form-group">
                <label for="sex">Sex</label>
<!--                <select id="sex" name="sex">-->
<!--                    <option value="Male" selected>Male</option>-->
<!--                    <option value="Female">Female</option>-->
<!--                    <option value="Other">Other</option>-->
<!--                </select>-->

                <select id="sex" name="sex">
                    <?php
                    $gender = isset($_SESSION['gender']) ? $_SESSION['sex'] : '';
                    $options = ['Male', 'Female', 'Other'];
                    foreach ($options as $option) {
                        $selected = ($option === $gender) ? 'selected' : '';
                        echo "<option value=\"$option\" $selected>$option</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit">Update Profile</button>
            
            <?php
                error_found_while_updating_profile()
            ?>


        </form>
    </div>


    <!--  Users Posts  -->
<!--    <div class="post">-->
<!--        <h4>@alex_dev</h4>-->
<!--        <p>Just finished working on a new portfolio site. Loving how it turned out!</p>-->
<!--        <img src="https://picsum.photos/200/300" alt="Post image" style="display: block; max-width: 80%; height: auto; border-radius: 6px; margin: 1rem auto 10px; box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);">-->
<!--        <div class="meta">Posted on June 6, 2025</div>-->
<!--    </div>-->
<!---->
<!--    <div class="post">-->
<!--        <h4>@emma.codes</h4>-->
<!--        <p style="margin-top: 15px; margin-bottom: 20px; font-size: 25px; font-weight: 550;">Working late tonight on a new feature. Sometimes you just get into the zone.</p>-->
<!--        <div class="meta">Posted on June 5, 2025</div>-->
<!--    </div>-->
    <?php

        global $pdo;
        show_all_post_from_user($pdo);



    ?>


</div>
</body>
</html>
