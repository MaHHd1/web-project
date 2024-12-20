<?php
require_once '../../Controller/LoginController.php';  // Include your controller to handle database operations
require_once '../../Model/UserModel.php';  // Include your model for database operations

// Create an instance of the controller
$controller = new LoginController();

// Get the user ID from the URL (GET)
$userId = isset($_GET['id']) ? $_GET['id'] : null;

// If the form is submitted via POST, update the user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the 'id' is sent in POST request
    if (isset($_POST['id'])) {
        $userId = $_POST['id'];
        $email = $_POST['email'];
        $password = $_POST['password']; // You can hash the password before saving it
        $phone = $_POST['phone'];
        $country = $_POST['country'];
        $role = $_POST['role'];

        // Handle profile image upload (optional)
        $image = $_FILES['image']['name'];
        if ($image) {
            // Process the image upload and save the path
            $imagePath = "uploads/" . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        } else {
            $imagePath = $user['IMG']; // Keep the existing image if not uploading a new one
        }

        // Update the user in the database
        $result = $controller->updateUser($userId, $email, password_hash($password, PASSWORD_DEFAULT), $phone, $country, $role, $imagePath);

        if ($result) {
            echo "User updated successfully!";
            header("Location: index.php");  // Redirect to user list or profile page
            exit;
        } else {
            echo "Failed to update user.";
        }
    }
}

// Get user data from the database
if ($userId) {
    $user = $controller->getUserById($userId);

    if (!$user) {
        echo "User not found!";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Edit User</title>
    <link href="edit.css" rel="stylesheet">
</head>
<body>

<!-- User Update Form -->
<form method="POST" action="edit.php?id=<?php echo htmlspecialchars($userId); ?>" enctype="multipart/form-data">
    <!-- Hidden input to pass user ID -->
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

    <!-- Email Field -->
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['mail']); ?>" required>

    <!-- Password Field -->
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($user['psw']); ?>" required>

    <!-- Phone Field -->
    <label for="phone">Phone Number:</label>
    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>

    <!-- Country Field -->
    <label for="country">Country:</label>
    <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($user['Country']); ?>" required>

    <!-- Role Field (Privilege) -->
    <label for="role">Role (Privilege):</label>
    <select name="role" id="role" required>
        <option value="1" <?php echo ($user['privilege'] == 1) ? 'selected' : ''; ?>>Admin</option>
        <option value="2" <?php echo ($user['privilege'] == 2) ? 'selected' : ''; ?>>User</option>
    </select>

    <!-- Display Profile Image if it exists -->
    <label for="image">Profile Image:</label>
    <?php if (!empty($user['IMG'])): ?>
        <div>
            <img src="<?php echo htmlspecialchars($user['IMG']); ?>" alt="Profile Image" style="max-width: 150px; max-height: 150px; margin-bottom: 10px;">
        </div>
    <?php else: ?>
        <div>
            <p>No profile image selected.</p>
        </div>
    <?php endif; ?>

    <!-- File Upload for New Image -->
    <input type="file" id="image" name="image">

    <!-- Submit Button -->
    <button type="submit">Update User</button>
</form>

<!-- Back Link -->
<a href="DataTable.php">Back to Users</a>

</body>
</html>
