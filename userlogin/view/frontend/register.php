<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="main.css">
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

<div class="account-container">
    <div class="account-box">
        <div class="account-tabs">
            <a href="login.php">Log in</a>
            <a href="#" class="active">Create new account</a>
            <a href="reset_password.html">Reset your password</a>
        </div>

        <form action="#" method="post">
            <label for="username">Username *</label>
            <input type="text" id="username" name="username" placeholder="Choose a username" required>

            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address" required>

            <label for="country">Country *</label>
            <select id="country" name="country" required>
                <option value="">Select your country</option>
                <option value="US">United States</option>
                <option value="CA">Canada</option>
                <option value="UK">United Kingdom</option>
                <option value="AU">Australia</option>
                <option value="IN">India</option>
                <!-- Add more countries as needed -->
            </select>

            <label for="source">Where did you hear about us? *</label>
            <select id="source" name="source" required>
                <option value="">Select an option</option>
                <option value="social_media">Social Media</option>
                <option value="search_engine">Search Engine</option>
                <option value="friend">Friend</option>
                <option value="ad">Advertisement</option>
                <option value="other">Other</option>
            </select>

            <label for="password">Password *</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required>
                <button type="button" class="toggle-password">👁️</button>
            </div>

            <label for="confirm_password">Confirm Password *</label>
            <div class="password-container">
                <input type="password" id="confirm_password" name="confirm_password" required>
                <button type="button" class="toggle-password">👁️</button>
            </div>
            <div class="captcha-box">
                <span>I'm not a robot</span>
                <input type="checkbox" required>
            </div>

            <button type="submit" class="create-account-button">Create Account</button>
        </form>
    </div>
</div>
</body>
</html>





