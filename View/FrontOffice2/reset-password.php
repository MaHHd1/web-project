<?php
require_once '../../Model/config.php'; // Include database connection

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validate the token
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = :token AND reset_token_expires_at > NOW()");
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $error = "Invalid or expired token.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $token = $_POST['token'];

    if (!empty($password) && !empty($confirmPassword) && !empty($token)) {
        // Check if passwords match
        if ($password === $confirmPassword) {
            // Validate token
            $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = :token AND reset_token_expires_at > NOW()");
            $stmt->execute(['token' => $token]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Update the user's password and clear the reset token
                $updateStmt = $pdo->prepare("UPDATE users SET psw = :password, reset_token = NULL, reset_token_expires_at = NULL WHERE reset_token = :token");
                $updateStmt->execute(['password' => $hashedPassword, 'token' => $token]);

                $success = "Your password has been reset successfully.";
            } else {
                $error = "Invalid or expired token.";
            }
        } else {
            $error = "The passwords do not match.";
        }
    } else {
        $error = "Please enter both password fields.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" type="text/css" href="reset.css">
</head>
<body>

<?php if ($error): ?>
    <div class="error-message" style="color: red;"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if ($success): ?>
    <div class="success-message" style="color: green;"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php if (!isset($success) || empty($success)): ?>
    <form method="post" action="reset-password.php">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">
        <label for="password">Enter your new password:</label><br>
        <input type="password" name="password" id="password" required><br><br>

        <label for="confirm_password">Confirm your new password:</label><br>
        <input type="password" name="confirm_password" id="confirm_password" required><br><br>

        <button type="submit" name="reset_password">Reset Password</button>
    </form>
<?php endif; ?>
</body>
</html>