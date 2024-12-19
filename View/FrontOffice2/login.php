<?php
require_once '../../Controller/LoginController.php';
require_once '../../Model/UserModel.php';

$error = "";
$success = "";
$recaptcha_secret = "6LcHF5oqAAAAAFkbzbA12RY3yW9DrdoZSVSRLi_S"; // Replace with actual Secret Key
session_start(); // Start the session to store CAPTCHA

// Generate a random custom CAPTCHA string if it doesn't exist
if (!isset($_SESSION['custom_captcha'])) {
    $_SESSION['custom_captcha'] = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, 6);
}

if (isset($_POST['g-recaptcha-response'])) {
    $recaptcha_response = $_POST['g-recaptcha-response'];

    // Make a POST request to Google's reCAPTCHA server
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);

    // Check if reCAPTCHA was successful
    if (!$recaptcha->success) {
        $error = "CAPTCHA verification failed. Please try again.";
    }
} else {
    $error = "Please complete the CAPTCHA.";
}


// Handle Signup
if (isset($_POST['signup']) && empty($error)) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (!empty($email) && !empty($password)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $loginController = new LoginController();
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Register new user with privilege = 0
            if ($loginController->registerUser($email, $passwordHash, 0)) {
                $success = "Signup successful! You can now log in.";
            } else {
                $error = "Signup failed. Email already exists or another error occurred.";
            }
        } else {
            $error = "Invalid email format.";
        }
    } else {
        $error = "All fields are required.";
    }
}

// Handle Login
if (isset($_POST['signin'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (!empty($email) && !empty($password)) {
        $loginController = new LoginController();

        // Create a User object with the provided email and password
        $user = new User($email, $password);

        // Check if the user is valid and sign them in
        $result = $loginController->signin($user);

        if ($result === "admin") {
            // Get admin details (name and profile image) from the database
            $adminDetails = $loginController->getAdminDetails($email);
            // Set session variables for the admin name and image
            $_SESSION['admin_name'] = $adminDetails['Uname'];  // Admin's name from the database
            $_SESSION['admin_image'] = $adminDetails['IMG'];  // Admin's profile image

            // Redirect to the admin dashboard
            header("Location: ../BackOffice/index.php");
            exit;
        } elseif ($result === "user") {
            // If user, redirect to the profile page
            header("Location: profile.php");
            exit;
        } else {
            // If invalid credentials
            $error = "Invalid email or password.";
        }
    } else {
        $error = "All fields are required.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website with Login & Signup Form</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LcHF5oqAAAAAKbr_gZ-hVznO3hcuVPt5umdjNjs"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>
<body>
<header>
    <nav class="navbar">
        <span class="hamburger-btn material-symbols-rounded">menu</span>
        <a href="#" class="logo">
            <img src="images/lg.png" alt="logo">
            <h2>Organic</h2>
        </a>
        <ul class="links">
            <span class="close-btn material-symbols-rounded">close</span>
            <li><a href="#">Home</a></li>
            <li><a href="index.php">Products</a></li>
            <li><a href="#">Our stores</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Contact us</a></li>
        </ul>
        <button class="login-btn" id="login-btn">LOG IN</button>
    </nav>
</header>

<div class="blur-bg-overlay"></div>
<div class="form-popup">
    <span class="close-btn material-symbols-rounded">close</span>

    <!-- Display error or success messages -->
    <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="success-message"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <!-- Login Form -->
    <div class="form-box login">
        <div class="form-details">
            <h2>Welcome Back</h2>
            <p>Please log in using your personal information to stay connected with us.</p>
        </div>
        <div class="form-content">
            <h2>LOGIN</h2>
            <form method="post" action="login.php">
                <div class="input-field">
                    <input type="email" name="email" required>
                    <label>Enter your email</label>
                </div>
                <div class="input-field">
                    <input type="password" name="password" required>
                    <label>Enter your password</label>
                </div>
                <div class="policy-text">
                    <input type="checkbox" id="policy" required>
                    <label for="policy">
                        I agree to the
                        <a href="#" class="option">Terms & Conditions</a>
                    </label>
                </div>

                <!-- Google reCAPTCHA Widget -->
                <div class="g-recaptcha" data-sitekey="6LcHF5oqAAAAAKbr_gZ-hVznO3hcuVPt5umdjNjs" data-size="normal"></div>

                <button type="submit" name="signin">Sign In</button>
            </form>

            <!-- Forgot Password Link -->
            <div class="bottom-link">
                <a href="password.php">Forgot your password?</a>
            </div>

            <div class="bottom-link">
                Don't have an account?
                <a href="#" id="signup-link">Signup</a>
            </div>
        </div>
    </div>

    <!-- Signup Form -->
    <div class="form-box signup">
        <div class="form-details">
            <h2>Create Account</h2>
            <p>To become a part of our community, please sign up using your personal information.</p>
        </div>
        <div class="form-content">
            <h2>SIGNUP</h2>
            <form method="POST" action="login.php">
                <div class="input-field">
                    <input type="email" name="email" required>
                    <label>Enter your email</label>
                </div>
                <div class="input-field">
                    <input type="password" name="password" required>
                    <label>Create a password</label>
                </div>
                <div class="policy-text">
                    <input type="checkbox" id="policy" required>
                    <label for="policy">
                        I agree to the
                        <a href="#" class="option">Terms & Conditions</a>
                    </label>
                </div>

                <!-- Google reCAPTCHA Widget -->
                <div class="g-recaptcha" data-sitekey="6LcHF5oqAAAAAKbr_gZ-hVznO3hcuVPt5umdjNjs"></div>

                <button type="submit" name="signup">Sign Up</button>
                <p class="error-message"></p>
            </form>
            <div class="bottom-link">
                Already have an account?
                <a href="#" id="login-link">Login</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>


