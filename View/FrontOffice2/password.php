<?php

require_once '../../Model/config.php'; // Include database connection
require_once __DIR__ . '/../../vendor/autoload.php'; // Adjust path as necessary

$error = "";
$success = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_request'])) {
    $email = trim($_POST['email']);
    $reset_method = $_POST['reset_method']; // Get the chosen reset method

    if (!empty($email)) {
        // Check if the email exists in the users table
        $stmt = $pdo->prepare("SELECT * FROM users WHERE mail = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $token = bin2hex(random_bytes(32)); // Generate secure token
            $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expiry (1 hour)

            // Save the token and expiration time to the users table
            $stmt = $pdo->prepare("UPDATE users SET reset_token = :token, reset_token_expires_at = :expires_at WHERE mail = :email");
            $stmt->execute(['token' => $token, 'expires_at' => $expires_at, 'email' => $email]);

            if ($reset_method == 'sms') {
                // Twilio configuration for SMS
                $twilio_sid = 'AC0859a5e776f96267f77f46bc62039c1b';
                $twilio_auth_token = '3053d9b1135e3e019540e9f2b90f1968';
                $twilio_phone_number = '+13613221318';

                $phone_number = $user['phone']; // Assuming the phone number is stored in the database

                if ($phone_number) {
                    // Send SMS using Twilio
                    try {
                        $client = new Twilio\Rest\Client($twilio_sid, $twilio_auth_token);
                        $reset_link = "http://localhost/USER/View/FrontOffice2/reset-password.php?token=$token";

                        $message = $client->messages->create(
                            $phone_number, // To phone number
                            [
                                'from' => $twilio_phone_number, // Twilio phone number
                                'body' => "Click the link below to reset your password:\n\n$reset_link\n\nThis link will expire in 1 hour."
                            ]
                        );

                        $success = "Password reset SMS has been sent.";
                    } catch (Exception $e) {
                        $error = "Failed to send SMS: " . $e->getMessage();
                    }
                } else {
                    $error = "No phone number found for this user.";
                }
            }
            else if ($reset_method == 'email') {
                // Send password reset email
                $reset_link = "http://localhost/USER/View/FrontOffice2/reset-password.php?token=$token";
                $subject = "Password Reset Request";
                $message = "Click the link below to reset your password:\n\n$reset_link\n\nThis link will expire in 1 hour.";
                $headers = "From: no-reply@yourdomain.com"; // Replace with a valid sender email

                if (mail($email, $subject, $message, $headers)) {
                    $success = "Password reset email has been sent.";
                } else {
                    $error = "Failed to send email. Please try again.";
                }
            }
        } else {
            $error = "No account found with this email.";
        }
    } else {
        $error = "Please enter your email.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="pass.css">
</head>
<body>
<h2>Reset Your Password</h2>

<?php if ($error): ?>
    <div class="error-message"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="success-message"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="post" action="password.php">
    <label for="email">Enter your email address:</label>
    <input type="email" name="email" id="email" required>

    <!-- Choose reset method -->
    <p>Select a method to receive your reset link:</p>
    <input type="radio" id="email" name="reset_method" value="email" checked>
    <label for="email">Email</label><br>
    <input type="radio" id="sms" name="reset_method" value="sms">
    <label for="sms">SMS</label><br>

    <button type="submit" name="reset_request">Send Reset Link</button>
</form>
</body>
</html>

