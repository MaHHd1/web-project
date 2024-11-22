<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="navbar">
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Videos</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">How To...</a></li>
        <li><a href="#">Resources</a></li>
        <li><a href="#">Latest</a></li>
        <li><a href="#">Impact</a></li>
    </ul>
</div>

<div class="stats">
    <span>👥 90,000,000 viewers</span>
    <span>📸 266 entrepreneurs in 18 countries</span>
    <span>📹 4,647 agroecology videos</span>
    <span>🌐 107 languages available</span>
</div>

<div class="reset-container">
    <div class="reset-box">
        <div class="reset-tabs">
            <a href="login.php">Log in</a>
            <a href="create_account.html">Create new account</a>
            <a href="#" class="active">Reset your password</a>
        </div>

        <form action="#" method="post">
            <p class="reset-instructions">Enter your email address below, and we’ll send you a link to reset your password.</p>

            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address" required>

            <button type="submit" class="reset-button">Send Reset Link</button>
        </form>
    </div>
</div>
</body>
</html>
