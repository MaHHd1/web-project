<?php
require_once '../../Controller/LoginController.php';
require_once '../../Model/UserModel.php';

$error = "";
$success = "";

// Handle admin account creation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (!empty($email) && !empty($password)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $loginController = new LoginController();

            // Insert the new admin with privilege set to 1
            $query = "INSERT INTO users (mail, psw, privilege) VALUES (:mail, :psw, 1)";
            $stmt = $loginController->db->prepare($query);
            $stmt->bindParam(':mail', $email);
            $stmt->bindParam(':psw', $passwordHash);

            if ($stmt->execute()) {
                $success = "Admin account created successfully!";
            } else {
                $error = "Failed to create admin account.";
            }
        } else {
            $error = "Invalid email format.";
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
    <title>Create Admin Account</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Create Admin Account</h1>

<!-- Display error or success messages -->
<?php if ($error): ?>
    <div class="error-message"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if ($success): ?>
    <div class="success-message"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<!-- Form to create admin -->
<form method="POST" action="create_admin.php">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Create Admin</button>
</form>

<!-- Link to go back -->
<a href="admin_dashboard.php">Back to Admin Dashboard</a>
</body>
</html>
