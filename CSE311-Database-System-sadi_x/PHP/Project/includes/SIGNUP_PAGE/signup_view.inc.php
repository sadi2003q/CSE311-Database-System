<?php

declare(strict_types=1);


// This function will be active when there will be any error found
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



// Input Field for signing up
function signup_input(): void {
    // Username field
    echo '<div class="form-group">';
    echo '<input
        type="text"
        id="username"
        name="username"
        class="form-input"
        placeholder="Username"
        value="' . (isset($_SESSION['signup_data']['username']) && !isset($_SESSION['error_signup']['username_taken']) ? htmlspecialchars($_SESSION['signup_data']['username']) : '') . '">';
    echo '</div>';

    // Email field
    echo '<div class="form-group">
        <input
            type="email"
            id="email"
            name="email"
            class="form-input"
            placeholder="Email address"
            value="' . (isset($_SESSION['signup_data']['email']) ? htmlspecialchars($_SESSION['signup_data']['email']) : '') . '"
        >
    </div>';

    // Password field
    echo '<div class="form-group">
        <input
            type="password"
            id="password"
            name="password"
            class="form-input"
            placeholder="New password"
        >
    </div>';

    // Gender field
    $gender = $_SESSION['signup_data']['gender'] ?? '';
    echo '<div class="form-group">
        <select id="gender" name="gender" class="form-input">
            <option value="" style = "color: #8d949e; font-size: 14px;">Gender</option>
            <option value="male"' . ($gender === 'male' ? ' selected' : '') . '>Male</option>
            <option value="female"' . ($gender === 'female' ? ' selected' : '') . '>Female</option>
            <option value="other"' . ($gender === 'other' ? ' selected' : '') . '>Other</option>
        </select>
    </div>';

    // Date of Birth field
    echo '<div class="form-group">
        <input
            type="date"
            id="dob"
            name="dob"
            class="form-input"
            placeholder="Birthday"
            value="' . (isset($_SESSION['signup_data']['dob']) ? htmlspecialchars($_SESSION['signup_data']['dob']) : '') . '"
        >
    </div>';
}




