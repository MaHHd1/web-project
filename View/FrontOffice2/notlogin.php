<?php
require_once '../../Controller/LoginController.php';
require_once '../../Model/UserModel.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (!empty($email) && !empty($password)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $user = new User($email, $password);
            $loginController = new LoginController();

            if ($loginController->signup($user)) {
                $success = "Siougnup successful! Y can now log in.";
            } else {
                $error = "Signup failed. Email already exists.";
            }
        } else {
            $error = "Invalid email format.";
        }
    } else {
        $error = "All fields are required.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signin'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (!empty($email) && !empty($password)) {
        $user = new User($email, $password);
        $loginController = new LoginController();

        if ($loginController->signin($user)) {
            $success = "Login successful! Welcome back.";
        } else {
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
    <title>Login & Signup</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <!-- Signup Form -->
    <form method="POST" action="">
        <h2>Signup</h2>
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="signup">Sign Up</button>
        <!-- Display Messages -->
        <?php if (!empty($success) && isset($_POST['signup'])): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php endif; ?>
        <?php if (!empty($error) && isset($_POST['signup'])): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
    </form>

    <!-- Login Form -->
    <form method="POST" action="">
        <h2>Login</h2>
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="signin">Sign In</button>
        <!-- Display Messages -->
        <?php if (!empty($success) && isset($_POST['signin'])): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php endif; ?>
        <?php if (!empty($error) && isset($_POST['signin'])): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
    </form>
</div>
</body>
</html>
