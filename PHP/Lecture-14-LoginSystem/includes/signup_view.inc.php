<?php

declare(strict_types=1);

function check_signup_errors(): void {
    if(isset($_SESSION['error_signup'])) {
        $errors = $_SESSION['error_signup'];

        if (isset($_GET['signup']) and $_GET['signup'] === 'failed') {
            echo "<br>";
            echo "<p style='color: orangered; font-weight: bolder; text-decoration: underline;'>SignIn Failed!!!</p><br>";
        }


        foreach($errors as $error) {
            echo "<p style='font-weight: bold; color: indianred;'>" . $error . "</p> <br>";
        }

        unset($_SESSION['error_signup']);
    } else if (isset($_GET['signup']) and $_GET['signup'] === 'success') {
        echo "<br>";
        echo "<p style='color: darkolivegreen; font-weight: bold;'>You have successfully signed up!</p>";
    }
}


//function signup_input(): void {
//    if(isset($_SESSION['signup_data']['username']) and !isset($_SESSION['error_signup']['username_taken'])) {
//        echo '<div class="form-group">
//        <label for="username" class="form-label">Username</label>
//        <input
//                type="text"
//                id="username"
//                name="username"
//                class="form-input"
//                placeholder="Choose a username"
//                value="' . $_SESSION['signup_data']['username'] . '"
//                >
//    </div>';
//    } else {
//        echo '<div class="form-group">
//        <label for="username" class="form-label">Username</label>
//        <input
//                type="text"
//                id="username"
//                name="username"
//                class="form-input"
//        ';
//    }
//
//
//   if(isset($_SESSION['signup_data']['email']) and !isset($_SESSION['error_signup']['email_taken'])) {
//       echo '<div class="form-group">
//        <label for="email" class="form-label">Email Address</label>
//        <input
//                type="email"
//                id="email"
//                name="email"
//                class="form-input"
//                placeholder="Enter your email"
//                value = "' . $_SESSION['signup_data']['email'] . '"
//                >
//        </div>';
//
//   } else {
//       echo '<div class="form-group">
//        <label for="email" class="form-label">Email Address</label>
//        <input
//                type="email"
//                id="email"
//                name="email"
//                class="form-input"
//                placeholder="Enter your email" >
//        </div> ';
//   }
//
//
//    echo ' <div class="form-group">
//        <label for="password" class="form-label">Password</label>
//        <input
//                type="password"
//                id="password"
//                name="password"
//                class="form-input"
//                placeholder="Create a password">
//    </div>';
//
//
//   echo ' <div class="form-group">
//            <label for="gender" class="form-label">Gender</label>
//            <select id="gender" name="gender" class="form-input">
//                <option value="">Select gender</option>
//                <option value="male">Male</option>
//                <option value="female">Female</option>
//                <option value="other">Other</option>
//            </select>
//        </div>';
//
//
//    if(isset($_SESSION['signup_data']['dob']) and !isset($_SESSION['error_signup']['age_invalid'])) {
//        echo '<div class="form-group">
//            <label for="dob" class="form-label">Date of Birth</label>
//            <input
//                    type="date"
//                    id="dob"
//                    name="dob"
//                    class="form-input"
//                    value="' . $_SESSION['signup_data']['dob'] . '"
//            >
//        </div>';
//
//    } else {
//        echo '<div class="form-group">
//            <label for="dob" class="form-label">Date of Birth</label>
//            <input
//                    type="date"
//                    id="dob"
//                    name="dob"
//                    class="form-input"
//            >
//        </div>';
//    }
//
//
//
//}




function signup_input(): void {
    // Username field (already working)
    if(isset($_SESSION['signup_data']['username']) && !isset($_SESSION['error_signup']['username_taken'])) {
        echo '<div class="form-group">
        <label for="username" class="form-label">Username</label>
        <input
                type="text"
                id="username"
                name="username"
                class="form-input"
                placeholder="Choose a username"
                value="' . htmlspecialchars($_SESSION['signup_data']['username']) . '"
                >
    </div>';
    } else {
        echo '<div class="form-group">
        <label for="username" class="form-label">Username</label>
        <input
                type="text"
                id="username"
                name="username"
                class="form-input"
                placeholder="Choose a username"
        >
    </div>';
    }

    // Email field - fixed
    echo '<div class="form-group">
        <label for="email" class="form-label">Email Address</label>
        <input
                type="email"
                id="email"
                name="email"
                class="form-input"
                placeholder="Enter your email" 
                value="' . (isset($_SESSION['signup_data']['email']) ? htmlspecialchars($_SESSION['signup_data']['email']) : '') . '"
        >
    </div>';

    // Password field (should not persist)
    echo '<div class="form-group">
        <label for="password" class="form-label">Password</label>
        <input
                type="password"
                id="password"
                name="password"
                class="form-input"
                placeholder="Create a password">
    </div>';

    // Gender field - fixed
    $gender = $_SESSION['signup_data']['gender'] ?? '';
    echo '<div class="form-group">
        <label for="gender" class="form-label">Gender</label>
        <select id="gender" name="gender" class="form-input">
            <option value="">Select gender</option>
            <option value="male"' . ($gender === 'male' ? ' selected' : '') . '>Male</option>
            <option value="female"' . ($gender === 'female' ? ' selected' : '') . '>Female</option>
            <option value="other"' . ($gender === 'other' ? ' selected' : '') . '>Other</option>
        </select>
    </div>';

    // Date of Birth - fixed
    echo '<div class="form-group">
        <label for="dob" class="form-label">Date of Birth</label>
        <input
                type="date"
                id="dob"
                name="dob"
                class="form-input"
                value="' . (isset($_SESSION['signup_data']['dob']) ? htmlspecialchars($_SESSION['signup_data']['dob']) : '') . '"
        >
    </div>';
}





