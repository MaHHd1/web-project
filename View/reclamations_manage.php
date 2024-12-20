<?php
require_once '../config/DbConfig.php';
require_once '../controller/ReclamationController.php';
require_once '../controller/ReponseController.php';

$reclamationController = new ReclamationController();
$reclamations = $reclamationController->getAll();

$reponseController = new ReponseController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['response'])) {
    $reclamationId = $_POST['reclamationId'];
    $responseText = $_POST['response'];
    $utilisateurId = 1; 

    $reponseController->create($reclamationId, $utilisateurId, $responseText);
    header('Location: reclamations_manage.php');
    exit();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteReclamationId'])) {
    $reclamationId = $_POST['deleteReclamationId'];
    $reclamationController->delete($reclamationId);
    header('Location: reclamations_manage.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteResponseId'])) {
    $responseId = $_POST['deleteResponseId'];
    $reponseController->delete($responseId);
    header('Location: reclamations_manage.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Reclamations</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .sidebar {
            min-height: 100vh;
            transition: background-color 0.3s, transform 0.3s;
        }
        .sidebar a{
            padding:10px;
            transition: background-color 0.3s, transform 0.3s;
        }
        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }
        .card-title {
            font-size: 1.5rem;
        }
        .navbar-brand img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .btn-round {
            border-radius: 50px;
        }
        .card {
            background-color: rgb(238, 238, 238);
            transition: box-shadow 0.3s, transform 0.3s;
        }
        .card:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            transform: translateY(-10px);
        }
        .card-header {
            background-color: rgb(91, 91, 221);
            color: #fff;
        }
        .card-body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 bg-dark text-white d-flex flex-column sidebar py-4 px-3 shadow">
                <h3 class="fw-medium mb-4"><i class="bi bi-speedometer2"></i> Admin Panel</h3>
                <a href="BackOffice/index.php" class="text-white mb-3 text-decoration-none"><i class="bi bi-house-door"></i> Dashboard</a>
                <a href="BackOffice/DataTable.php" class="text-white mb-3 text-decoration-none"><i class="bi bi-people"></i> Users</a>
                <a href="BackOffice/AdminProfile.php" class="text-white mb-3 text-decoration-none"><i class="bi bi-box-seam"></i> admin profile</a>
                <a href="BackOffice/ajouterProduit.php" class="text-white mb-3 text-decoration-none"><i class="bi bi-gear"></i> Add event</a>
                <a href="BackOffice/addArticle.php" class="text-white mb-3 text-decoration-none"><i class="bi bi-house-door"></i>add article</a>

                <a href="BackOffice/listArticles.php" class="text-white mb-3 text-decoration-none"><i class="bi bi-house-door"></i> liste article</a>
                <a href="BackOffice/pg.php" class="text-white mb-3 text-decoration-none"><i class="bi bi-house-door"></i> liste event</a>
                <a href="backend/Productlist.php" class="text-white mb-3 text-decoration-none"><i class="bi bi-house-door"></i> liste produit</a>
                <a href="reclamations_manage.php" class="text-white mb-3 text-decoration-none"><i class="bi bi-house-door"></i>reclamations manage</a>
                <a href="" class="text-white mb-3 text-decoration-none"><i class="bi bi-house-door"></i> Question</a>

            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
                    <div class="container-fluid">
                        <a class="navbar-brand fw-bold" href="#">
                            <img src="https://via.placeholder.com/40" alt="Logo">
                            Vege Dashboard
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Notifications <span class="badge bg-danger">3</span></a></li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="https://via.placeholder.com/40" alt="Admin Profile" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                        Admin
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="#">Profile</a></li>
                                        <li><a class="dropdown-item" href="#">Settings</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <!-- Content -->
                <div class="container mt-4 ">
                    <h2 class="mb-4 text-dark">List of Reclamations</h2>
                    <?php foreach ($reclamations as $reclamation): ?>
                        <div class="card mb-4 shadow-sm border-0">
                            <div class="card-header">
                                <h5 class="card-title" style="font-size:19px">Reclamation id : <?= htmlspecialchars($reclamation->getId()) ?></h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <strong>Utilisateur ID:</strong> <?= htmlspecialchars($reclamation->getUtilisateurId()) ?><br>
                                    <strong>Produit ID:</strong> <?= htmlspecialchars($reclamation->getProduitId()) ?><br>
                                    <strong>Description:</strong> <?= htmlspecialchars($reclamation->getContent()) ?><br>
                                    <strong>Note:</strong> <?= htmlspecialchars($reclamation->getNote()) ?><br>
                                </p>

                                <!-- Response Form -->
                                <form action="" method="post" class="mt-3" onsubmit="return validateResponseForm(<?= htmlspecialchars($reclamation->getId()) ?>)">
                                <input type="hidden" name="reclamationId" value="<?= htmlspecialchars($reclamation->getId()) ?>">
                                <div class="mb-3">
                             <label for="response-<?= htmlspecialchars($reclamation->getId()) ?>" class="form-label fw-bold">Add a Response:</label>
                            <textarea id="response-<?= htmlspecialchars($reclamation->getId()) ?>" name="response" class="form-control" rows="3" placeholder="Enter your response here..."></textarea>
                          <small id="error-response-<?= htmlspecialchars($reclamation->getId()) ?>" class="text-danger"></small>
                          </div>
                         <button type="submit" class="btn btn-success btn-sm btn-round">Submit Response</button>
                           </form>


                                <!-- Display Responses -->
                                <?php 
                                $reponseModel = new Reponse();
                                $responses = $reponseModel->getByReclamationId($reclamation->getId());
                                if (count($responses) > 0): ?>
                                    <h5 class="mt-4 text-secondary">Responses:</h5>
                                    <ul class="list-group">
                                        <?php foreach ($responses as $response): ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <span class="fw-bold">User:</span> <?= htmlspecialchars($response->getUtilisateurId()) ?><br>
                                                    <?= htmlspecialchars($response->getReponseText()) ?><br>                                                </div>
                                                <form action="" method="post">
                                                    <input type="hidden" name="deleteResponseId" value="<?= htmlspecialchars($response->getId()) ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm"> <i class="bi bi-trash-fill"></i> Delete reponse </button>
                                                </form>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>

                                <!-- Edit and Delete Actions -->
                                <div class="mt-4">
                                <a href="edit_reclamation.php?id=<?= htmlspecialchars($reclamation->getId()) ?>" class="btn btn-warning btn-sm"><i class="bi bi-pen-fill"></i> Edit Reclamation</a>
                                    <form action="" method="post" class="d-inline">
                                        <input type="hidden" name="deleteReclamationId" value="<?= htmlspecialchars($reclamation->getId()) ?>">
                                        <button type="submit" class="btn btn-danger btn-sm"> <i class="bi bi-trash-fill"></i> Delete Reclamation</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    </script>
</body>
</html>
