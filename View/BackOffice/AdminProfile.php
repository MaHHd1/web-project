<?php
// Include necessary files
require_once '../../Model/UserModel.php';
require_once '../../Controller/LoginController.php';
require_once '../../Model/config.php';  // Ensure database connection is available

session_start(); // Ensure session is started

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Initialize the LoginController
$loginController = new LoginController();

// Function to get user image from the database (using LoginController)
function getUserImage($userId) {
    // Get the user's image from the database through LoginController
    global $loginController;

    // Fetch user data from the database
    $user = $loginController->getUserById($userId);

    if ($user && isset($user['IMG'])) {
        // Return the BLOB (user image)
        return $user['IMG'];
    } else {
        // If no image exists, return null or a default image
        return null;
    }
}

// Function to convert BLOB to Base64
function blobToBase64($blob) {
    return 'data:image/jpeg;base64,' . base64_encode($blob);
}

// Retrieve the user's image from the database (as a BLOB)
$userImage = getUserImage($userId);

// If user image is available and is a BLOB, convert it to Base64
if ($userImage) {
    $_SESSION['user_image'] = blobToBase64($userImage);
} else {
    // Use a default image if no image is found
    $_SESSION['user_image'] = 'assets/img/default-profile.jpg';
}

// Handle profile update (Name, Email, Phone)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fullName'], $_POST['email'], $_POST['phone'])) {
    // Get the updated data from the form
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Call the method to update the user information
    $updateSuccess = $loginController->updateUser($userId, $email, null, $fullName, null);

    if ($updateSuccess) {
        // Update the session variables to reflect the new data
        $_SESSION['user_name'] = $fullName;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_phone'] = $phone;

        // Provide feedback to the user
        echo "<p>Profile updated successfully!</p>";
    } else {
        echo "<p>Error updating profile. Please try again.</p>";
    }
}

// Handle profile image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profileImage'])) {
    $image = $_FILES['profileImage'];

    // Validate image file (e.g., size, type)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($image['type'], $allowedTypes) && $image['size'] <= 5000000) {
        // Generate a unique name for the image
        $imageName = uniqid() . '-' . basename($image['name']);
        $imagePath = 'uploads/profile_images/' . $imageName;

        // Move the uploaded image to the desired directory
        if (move_uploaded_file($image['tmp_name'], __DIR__ . '/../' . $imagePath)) {
            // Call the method to update the profile image in the database
            $updateImageSuccess = $loginController->updateProfileImage($userId, $imagePath);

            if ($updateImageSuccess) {
                // Update session with the new image path
                $_SESSION['user_image'] = $imagePath;
                header("Location: profile.php"); // Redirect to profile page
                exit();
            } else {
                echo "<p>Error updating image in the database.</p>";
            }
        } else {
            echo "<p>Error uploading image. Please try again.</p>";
        }
    } else {
        echo "<p>Invalid file type or size exceeded.</p>";
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Users / Profile - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
    * Template Name: NiceAdmin
    * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    * Updated: Apr 20 2024 with Bootstrap v5.3.3
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
            <img src="assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">NiceAdmin</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->



    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->





            <li class="nav-item dropdown pe-3">




    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
            <a class="nav-link collapsed" href="index.php">
                <i class="bi bi-grid"></i><span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <!-- Profile page link -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="DataTable.php">
                <i class="bi bi-person"></i><span>Table</span>
            </a>
        </li><!-- End Profile Nav -->
        <li class="nav-item">
            <a class="nav-link " href="AdminProfile.php">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Profile Page Nav -->


        <li class="nav-item">
            <a class="nav-link collapsed" href="ajouterProduit.php">
                <i class="bi bi-envelope"></i>
                <span>Add event</span>
            </a>
        </li><!-- End Contact Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="listArticles.php">
                <i class="bi bi-envelope"></i>
                <span>liste article    </span>
            </a>
        </li><!-- End Contact Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="pg.php">
                <i class="bi bi-envelope"></i>
                <span>liste event    </span>
            </a>
        </li><!-- End Contact Page Nav -->
        </li><!-- End Contact Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="../backend/Productlist.php">
                <i class="bi bi-envelope"></i>
                <span>liste produit    </span>
            </a>
        </li><!-- End Contact Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="../reclamations_manage.php">
                <i class="bi bi-envelope"></i>
                <span>         reclamations manage
    </span>
            </a>
        </li>
        
        
        <li class="nav-item">
            <a class="nav-link collapsed" href="">
                <i class="bi bi-envelope"></i>
                <span>        Question
    </span>
            </a>
        </li><!-- End Contact Page Nav -->
        <li class="nav-item">
            <a class="nav-link " href="contact.php">
                <i class="bi bi-envelope"></i>
                <span>Contact</span>
            </a>
        </li><!-- End Contact Page Nav -->

    </ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <?php
                // Assume $userId is the ID of the logged-in user
                $userId = $_SESSION['user_id'];

                // Create an instance of the LoginController
                $loginController = new LoginController();

                // Fetch the image from the database
                $imageData = $loginController->getUserImage($userId);
                ?>

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <!-- Display Profile Image -->
                        <?php if ($imageData): ?>
                            <img src="data:image/jpeg;base64,<?php echo $imageData; ?>" alt="Profile Image" class="rounded-circle">
                        <?php else: ?>
                            <img src="assets/img/default-profile.jpg" alt="Profile Image" class="rounded-circle">
                        <?php endif; ?>

                        <!-- Display User Name -->
                        <h2><?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name'], ENT_QUOTES) : 'No Name Set'; ?></h2>

                        <!-- Display User Role -->
                        <h3><?php echo isset($_SESSION['user_role']) ? htmlspecialchars($_SESSION['user_role'], ENT_QUOTES) : 'ADMIN'; ?></h3>

                        <div class="social-links mt-2">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>






            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                            </li>





                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">

                                <h5 class="card-title">Profile Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Full Name</div>
                                    <div class="col-lg-9 col-md-8">
                                        <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name'], ENT_QUOTES) : 'Nom non disponible'; ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Company</div>
                                    <div class="col-lg-9 col-md-8">
                                        <?php echo isset($_SESSION['user_company']) ? htmlspecialchars($_SESSION['user_company'], ENT_QUOTES) : 'Company not available'; ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Job</div>
                                    <div class="col-lg-9 col-md-8">
                                        <?php echo isset($_SESSION['user_job']) ? htmlspecialchars($_SESSION['user_job'], ENT_QUOTES) : 'Job not available'; ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Country</div>
                                    <div class="col-lg-9 col-md-8">
                                        <?php echo isset($_SESSION['user_country']) ? htmlspecialchars($_SESSION['user_country'], ENT_QUOTES) : 'Country not available'; ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Address</div>
                                    <div class="col-lg-9 col-md-8">
                                        <?php echo isset($_SESSION['user_address']) ? htmlspecialchars($_SESSION['user_address'], ENT_QUOTES) : 'Address not available'; ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone</div>
                                    <div class="col-lg-9 col-md-8">
                                        <?php echo isset($_SESSION['user_phone']) ? htmlspecialchars($_SESSION['user_phone'], ENT_QUOTES) : 'Phone not available'; ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">
                                        <?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email'], ENT_QUOTES) : 'Email not available'; ?>
                                    </div>
                                </div>

                            </div>


                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                <!-- Profile Edit Form -->
                                <form method="POST" action="">
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                        <div class="col-md-8 col-lg-9">
                                            <!-- Display current profile image -->
                                            <img src="<?php echo isset($_SESSION['user_image']) && $_SESSION['user_image'] ? htmlspecialchars($_SESSION['user_image'], ENT_QUOTES) : 'assets/img/default-profile.jpg'; ?>" alt="Profile Image" id="profileImage">
                                            <div class="pt-2">
                                                <!-- Link to upload new profile image -->
                                                <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image" data-bs-toggle="modal" data-bs-target="#uploadImageModal"><i class="bi bi-upload"></i></a>
                                                <!-- Link to remove profile image -->
                                                <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image" onclick="removeProfileImage()"><i class="bi bi-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="fullName" type="text" class="form-control" id="fullName"
                                                   value="<?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name'], ENT_QUOTES) : ''; ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="email" class="form-control" id="email"
                                                   value="<?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email'], ENT_QUOTES) : ''; ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="phone" type="text" class="form-control" id="phone"
                                                   value="<?php echo isset($_SESSION['user_phone']) ? htmlspecialchars($_SESSION['user_phone'], ENT_QUOTES) : ''; ?>">
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                                <!-- End Profile Edit Form -->

                            </div>






                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->


<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

</body>

</html>