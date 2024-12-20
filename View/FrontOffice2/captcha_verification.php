<?php
session_start();

// Include the necessary files for the controller and the user model
require_once '../../Controller/LoginController.php';  // Adjust path if needed

$error = "";

// Check if CAPTCHA verification is done
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input for CAPTCHA
    $userCaptchaInput = trim($_POST['captcha_input']);

    // Verify if the user input matches the CAPTCHA displayed on the page
    if ($userCaptchaInput === $_SESSION['captcha_code']) {
        // CAPTCHA verification passed
        $_SESSION['captcha_verified'] = true;

        // Proceed with login/signup after CAPTCHA verification
        $email = $_SESSION['email'] ?? '';  // The email stored in session after login/signup
        $password = $_SESSION['password'] ?? '';  // The password stored in session

        if (!empty($email) && !empty($password)) {
            $loginController = new LoginController();
            $user = new User($email, $password);  // Assuming you have a User class

            $result = $loginController->signin($user);  // Assuming signin method returns "admin" or "user"

            if ($result === "admin") {
                // Redirect to the admin dashboard
                header('Location: ../BackOffice/index.php');
                exit;
            } elseif ($result === "user") {
                // Redirect to the user profile page
                header('Location: profile.php');
                exit;
            } else {
                $error = "Invalid credentials.";
            }
        } else {
            $error = "Credentials missing, please try again.";
        }
    } else {
        $error = "Captcha not matched. Please try again.";
        $_SESSION['captcha_code'] = generateCaptcha();  // Regenerate CAPTCHA
    }
}

// Function to generate a random CAPTCHA string
function generateCaptcha() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $captcha = '';
    for ($i = 0; $i < 6; $i++) {
        $captcha .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $captcha;
}

// Store the generated CAPTCHA in the session
$_SESSION['captcha_code'] = generateCaptcha();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Captcha Verification</title>

    <!-- Link to the captcha-specific CSS -->
    <link rel="stylesheet" href="captcha.css">

    <!-- Font Awesome CDN Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
<div class="wrapper">
    <header>Captcha</header>
    <div class="captcha-area">
        <div class="captcha-img">
            <img src="captcha-bg.png" alt="Captcha Background">
            <span class="captcha"><?php echo $_SESSION['captcha_code']; ?></span> <!-- Display the CAPTCHA -->
        </div>
        <button class="reload-btn"><i class="fas fa-redo-alt"></i></button>
    </div>
    <form method="POST" action="captcha_verification.php" class="input-area">
        <input type="text" placeholder="Enter captcha" name="captcha_input" maxlength="6" spellcheck="false" required>
        <button type="submit" class="check-btn">Check</button>
    </form>
    <div class="status-text"><?php echo $error; ?></div>
</div>

<!-- Link to the captcha-specific JavaScript -->
<script src="captcha.js"></script>
</body>
</html>
