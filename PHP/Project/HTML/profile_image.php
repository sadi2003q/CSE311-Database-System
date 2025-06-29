<?php

require_once '../includes/config_session.inc.php';
$pdo = require_once '../includes/dbh.inc.php';


?>


<!-- 
    Profile Picture Upload Page 
    -> User can view and update their profile picture
    -> Upload image using form (POST to profile_image.inc.php)
    -> Preview selected image before uploading
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Picture - Social Media</title>
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

        .header {
            background-color: #1E3A8A;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: flex-start;
        }

        .back-button {
            padding: 0.5rem 1rem;
            background-color: #3B82F6;
            color: #FFFFFF;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background-color: #1E3A8A;
            transform: scale(1.05);
        }

        .container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 0 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-picture-box {
            background-color: #FFFFFF;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        .profile-picture-box h1 {
            color: #111827;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #D1D5DB;
            margin: 0 auto 1.5rem;
            object-fit: cover;
            border: 2px solid #3B82F6;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .button-group button,
        .button-group label {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        /* Upload Image (label) - Green */
        .button-group label {
            display: inline-block;
            background-color: #10B981;
            /* Green 500 */
            color: #FFFFFF;
            text-align: center;
        }

        .button-group label:hover {
            background-color: #059669;
            /* Green 600 */
            transform: scale(1.05);
        }

        /* Database Upload (button) - Blue */
        .button-group button[type="submit"] {
            background-color: #3B82F6;
            /* Blue 500 */
            color: #FFFFFF;
        }

        .button-group button[type="submit"]:hover {
            background-color: #1D4ED8;
            /* Blue 700 */
            transform: scale(1.05);
        }

        input[type="file"] {
            display: none;
        }

        @media (max-width: 768px) {
            .container {
                margin: 1rem auto;
            }

            .profile-picture-box {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>

    <!-- 
        Back Header Section 
        -> Contains back button to return to previous page
    -->
    <header class="header">
        <button class="back-button" onclick="history.back()">Back</button>
    </header>

    <!-- 
        Main Container 
        -> Centered layout with profile picture box
    -->
    <div class="container">
        <div class="profile-picture-box">

            <!-- 
                Display Current Profile Picture
                -> Fetched from session if available, otherwise default image
            -->
            <?php
                $image_url = '../uploads/' . ($_SESSION['image_url'] ?? 'male_profile_icon_image.png');
                echo '<img src="' . htmlspecialchars($image_url) . '" alt="Profile Picture" class="profile-picture" id="profileImage">';
            ?>

            <!-- 
                Upload Form 
                -> Allows user to select and upload a new image
                -> POST to: ../includes/PROFILE_PICTURE_PAGE/profile_image.inc.php
                -> Input: image file only
            -->
            <form action="../includes/PROFILE_PICTURE_PAGE/profile_image.inc.php" method="POST" enctype="multipart/form-data">
                <div class="button-group">
                    <!-- Button to select image -->
                    <label for="imageUpload">Select Image</label>
                    
                    <!-- Hidden file input -->
                    <input type="file" id="imageUpload" name="profile_picture" accept="image/*" onchange="previewImage(event)">
                    
                    <!-- Submit button -->
                    <button type="submit" id="uploadButton" disabled>Upload Image</button>
                </div>
            </form>

        </div>
    </div>

    <!-- 
        JavaScript Section 
        -> Preview image when selected
        -> Enable upload button only after image selected
        -> Prevent form submission if no image selected
    -->
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('profileImage');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        // Select DOM elements
        const fileInput = document.getElementById('imageUpload');
        const uploadButton = document.getElementById('uploadButton');
        const form = uploadButton.closest('form');

        // Enable the upload button when an image is selected
        fileInput.addEventListener('change', function () {
            uploadButton.disabled = fileInput.files.length === 0;
        });

        // Prevent form submission if no file is selected
        form.addEventListener('submit', function (e) {
            if (fileInput.files.length === 0) {
                e.preventDefault();
                alert('Please select an image before uploading.');
                uploadButton.disabled = true;
            }
        });
    </script>

</body>
</html>