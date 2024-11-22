<?php
require_once '../../Controller/LoginController.php';
require_once '../../Model/UserModel.php';

$error = ""; // Initialize error message variable
$success = ""; // Initialize success message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    // Sanitize input
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (!empty($email) && !empty($password)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Create a User object with the hashed password
            $user = new User($email, $hashedPassword);

            // Create a LoginController instance
            $loginController = new LoginController();

            // Call the signup method and handle response
            if ($loginController->signup($user)) {
                $success = "Signup successful!";
            } else {
                $error = "Signup failed. Email may already be in use.";
            }
        } else {
            $error = "Invalid email format.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website with Login & Signup Form | CodingNepal</title>
    <!-- Google Fonts Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
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
            <li><a href="#">Products</a></li>
            <li><a href="#">Our stores</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Contact us</a></li>
        </ul>
        <button class="login-btn">LOG IN</button>
    </nav>
</header>

<div class="blur-bg-overlay"></div>
<div class="form-popup">
    <span class="close-btn material-symbols-rounded">close</span>
    <div class="form-box login">
        <div class="form-details">
            <h2>Welcome Back</h2>
            <p>Please log in using your personal information to stay connected with us.</p>
        </div>
        <div class="form-content">
            <h2>LOGIN</h2>
            <form method="POST" action="login.php">
                <div class="input-field">
                    <input type="text" name="email" required>
                    <label>Enter your email</label>
                </div>
                <div class="input-field">
                    <input type="password" name="password" required>
                    <label>Create password</label>
                </div>
                <div class="policy-text">
                    <input type="checkbox" id="policy" required>
                    <label for="policy">
                        I agree to the
                        <a href="#" class="option">Terms & Conditions</a>
                    </label>
                </div>
                <button type="submit" name="signup">Sign Up</button>

                <!-- Display error or success messages -->
                <?php if (!empty($error)): ?>
                    <p style="color: red; margin-top: 10px;"><?php echo $error; ?></p>
                <?php endif; ?>
                <?php if (!empty($success)): ?>
                    <p style="color: green; margin-top: 10px;"><?php echo $success; ?></p>
                <?php endif; ?>
            </form>


            <div class="bottom-link">
                Don't have an account?
                <a href="#" id="signup-link">Signup</a>
            </div>
        </div>
    </div>
    <div class="form-box signup">
        <div class="form-details">
            <h2>Create Account</h2>
            <p>To become a part of our community, please sign up using your personal information.</p>
        </div>
        <div class="form-content">
            <h2>SIGNUP</h2>
            <form method="POST" action="login.php">
                <div class="input-field">
                    <input type="text" name="email" required>
                    <label>Enter your email</label>
                </div>
                <div class="input-field">
                    <input type="password" name="password" required>
                    <label>Create password</label>
                </div>
                <div class="policy-text">
                    <input type="checkbox" id="policy" required>
                    <label for="policy">
                        I agree to the
                        <a href="#" class="option">Terms & Conditions</a>
                    </label>
                </div>
                <button type="submit" name="signup">Sign Up</button>

                <!-- Display error or success messages -->
                <?php if (!empty($error)): ?>
                    <p style="color: red; margin-top: 10px;"><?php echo $error; ?></p>
                <?php endif; ?>
                <?php if (!empty($success)): ?>
                    <p style="color: green; margin-top: 10px;"><?php echo $success; ?></p>
                <?php endif; ?>
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


