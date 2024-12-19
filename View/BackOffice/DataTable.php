<?php
require_once '../../Controller/LoginController.php';  // Include your controller to fetch users
require_once '../../Model/UserModel.php';  // Include your model for database operations

// Create an instance of the controller
$controller = new LoginController();

// Handle user deletion if a delete request is made
if (isset($_POST['delete_user_id'])) {
    // Get the user ID to delete
    $userId = $_POST['delete_user_id'];

    // Call the controller's method to delete the user
    $controller->deleteUser($userId);

    // Refresh the page after deletion (to show the updated list)
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch all users from the database using the controller method
$users = $controller->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Dashboard - Users</title>

    <!-- Link to your external CSS file -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
</head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
            <img src="assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">NiceAdmin</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <!-- Your navigation code -->
    </nav><!-- End Icons Navigation -->
</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php">
                <i class="bi bi-grid"></i><span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="DataTable.php">
                <i class="bi bi-person"></i><span>Table</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="AdminProfile.php">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="ajouterProduit.php">
                <i class="bi bi-envelope"></i>
                <span>Add event</span>
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


<!-- ======= Main Content ======= -->
<main id="main" class="main">

    <div class="pagetitle">
        <h1>User Data</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Datatables</h5>
                        <p>Here is a list of all registered users. You can edit or delete them.</p>

                        <!-- Table with users, using the 'table-borderless' class -->
                        <table class="table table-borderless datatable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Country</th>
                                <th>Privilege</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($users)) : ?>
                                <?php foreach ($users as $user) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                                        <td><?php echo htmlspecialchars($user['mail']); ?></td>
                                        <td><?php echo htmlspecialchars($user['Uname']); ?></td>
                                        <td><?php echo htmlspecialchars($user['Country']); ?></td>
                                        <td>
                                            <?php
                                            if ($user['privilege'] == 1) {
                                                echo "Admin";
                                            } else {
                                                echo "User";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <!-- Edit Button: Sends user to the edit page -->
                                            <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-primary">Edit</a>

                                            <!-- Delete Button: Posts the ID to delete the user -->
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="delete_user_id" value="<?php echo $user['id']; ?>">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6">No users found.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                        <!-- End of Table -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->


<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>
