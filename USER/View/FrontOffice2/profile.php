<?php
session_start();

// Include database connection and controller
require_once '../../Controller/LoginController.php';
require_once '../../Model/UserModel.php';

// Initialize error and success messages
$error = "";
$success = "";

// Check if the user is logged in by checking session
if (!isset($_SESSION['user_id'])) {
    $error = "You are not logged in!";
    $user = null;
    header('location: login.php');
} else {
    // Fetch user profile info based on the logged-in user ID
    $userId = $_SESSION['user_id'];
    $loginController = new LoginController();
    $user = $loginController->getUserById($userId); // This should fetch user info including Uname, Country, and IMG
}

// Check if user data exists, if not, set an error message
if ($user === null) {
    $error = "User data could not be fetched.";
} else {
    // Safely access user data, as we now know it's set
    $userName = isset($user['Uname']) ? $user['Uname'] : '';
    $userCountry = isset($user['Country']) ? $user['Country'] : '';
    $userImage = isset($user['IMG']) ? $user['IMG'] : '';
}

// Handle Profile Image Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $targetDir = "uploads/"; // The directory where images will be saved

    // Check if the uploads directory exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Create the uploads directory if it doesn't exist
    }

    // Generate a unique file name for the uploaded image
    $fileName = uniqid() . "-" . basename($_FILES['profile_image']['name']);
    $targetFilePath = $targetDir . $fileName;

    // Validate the file type (ensure it's an image)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $fileType = mime_content_type($_FILES['profile_image']['tmp_name']); // Check file type

    if (!in_array($fileType, $allowedTypes)) {
        $error = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
    } elseif (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFilePath)) {
        // File uploaded successfully
        // Update the database with the new image file path
        if ($loginController->updateProfileImage($userId, $targetFilePath)) {
            $success = "Profile image updated successfully!";
            $user['IMG'] = $targetFilePath; // Update the displayed image
        } else {
            $error = "Failed to update the database.";
        }
    } else {
        $error = "Failed to upload the file. Please check folder permissions.";
    }
}

// Handle Profile Information Update (Uname, Country)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $uname = trim($_POST['uname']);
    $country = trim($_POST['country']);

    // Validate fields
    if (!empty($uname) && !empty($country)) {
        if ($loginController->updateUserProfile($userId, $uname, $country)) {
            $success = "Profile information updated successfully!";
            $user['Uname'] = $uname;
            $user['Country'] = $country;
        } else {
            $error = "Failed to update profile information.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}

// Handle Logout
if (isset($_POST['logout'])) {
    session_unset();  // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to login page
    exit(); // Make sure no further code is executed
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>
<body>
<div class="main-content">
    <!-- Navbar, Profile Image, and Cover Header -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
        <div class="container-fluid">
            <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="#">User Profile</a>
        </div>
    </nav>

    <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/argon-dashboard/gh-pages/assets-old/img/theme/profile-cover.jpg'); background-size: cover; background-position: center top;">
        <span class="mask bg-gradient-default opacity-8"></span>
        <div class="container-fluid d-flex align-items-center">
            <div class="row">
                <div class="col-lg-7 col-md-10">
                    <h1 class="display-2 text-white">Hello <?php echo htmlspecialchars($user['Uname']); ?></h1>
                    <p class="text-white mt-0 mb-5">This is your profile page. You can see your progress and manage your profile.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--7">
        <div class="row">
            <!-- Profile Card with Image -->
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">
                                <a href="#">
                                    <img src="<?php echo htmlspecialchars($user['IMG']); ?>" class="rounded-circle">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0 pt-md-4">
                        <div class="text-center">
                            <h3>
                                <?php echo htmlspecialchars($user['Uname']); ?>
                            </h3>
                            <div class="h5 font-weight-300">
                                <i class="ni location_pin mr-2"></i><?php echo htmlspecialchars($user['Country']); ?>
                            </div>
                            <hr class="my-4">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Information Form -->
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <h3 class="mb-0">My Account</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <!-- Display success/error messages -->
                            <?php if ($success): ?>
                                <div class="success-message"><?= htmlspecialchars($success) ?></div>
                            <?php endif; ?>
                            <?php if ($error): ?>
                                <div class="error-message"><?= htmlspecialchars($error) ?></div>
                            <?php endif; ?>

                            <!-- User Information -->
                            <h6 class="heading-small text-muted mb-4">User Information</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-username">Username</label>
                                            <input type="text" id="input-username" name="uname" class="form-control form-control-alternative" placeholder="Username" value="<?php echo htmlspecialchars($user['Uname']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-email">Email address</label>
                                            <input type="email" id="input-email" class="form-control form-control-alternative" placeholder="Email" value="<?php echo htmlspecialchars($user['mail']); ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Country Field -->
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-country">Country</label>
                                            <input type="text" id="input-country" name="country" class="form-control form-control-alternative" placeholder="Country" value="<?php echo htmlspecialchars($user['Country']); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Profile Image Upload -->
                            <h6 class="heading-small text-muted mb-4">Profile Image</h6>
                            <div class="form-group">
                                <label class="form-control-label" for="profile_image">Change Profile Image</label>
                                <input type="file" id="profile_image" name="profile_image" class="form-control form-control-alternative">
                            </div>

                            <div class="text-center">
                                <button type="submit" name="update_profile" class="btn btn-success mt-4">Save Changes</button>
                                <button type="submit" name="logout" class="btn btn-danger mt-4">Logout</button>

                            </div>
                        </form>
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- JS for map can go here -->


<script src="map.js"></script>
</body>
</html>
