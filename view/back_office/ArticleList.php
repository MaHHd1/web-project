<?php
include '../../controller/ArticleController.php';

// Créer une instance du contrôleur
$ArticleC = new ArticleController();

// Appeler la méthode listArticle pour récupérer les données
$list = $ArticleC->listArticle();
?>
<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
    
        <title>Travel Offer List - Dashboard</title>
    
        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">
    
        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
    
    </head>
    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-text mx-3">Travel Booking <sup></sup></div>
        </a>
        <hr class="sidebar-divider my-0">
        <li class="nav-item active">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="addTraveloffer.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Add offer</span>
            </a>
        </li>
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Travel Offer List</h1>
                </div>

                <!-- Content Row -->
                <div class="row">
                    <div class="col-xl-12 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>ID</th>
                                                <th>Titre</th>
                                                <th>Contenu</th>
                                                <th>Image</th>
                                                <th>Date de création</th>
                                                <th colspan="2">Actions</th>
                                            </tr>
                                            
                                            <?php
                                            foreach ($list as $offer) {
                                                echo "<tr>";
                                                echo "<td>" . $offer['id'] . "</td>";
                                                echo "<td>" . $offer['titre'] . "</td>";
                                                echo "<td>" . $offer['contenu_txt'] . "</td>";
                                                
                                                // Afficher l'image, si elle existe
echo "<td>";
if (!empty($offer['contenu_img'])) {
    // Utiliser un chemin relatif pour accéder à l'image
    echo "<img src='../../" . ($offer['contenu_img']) . "' alt='Offer Image' width='100' />";
}
echo "</td>";

                                                
                                                // Afficher la date de création
                                                echo "<td>" . $offer['date_creation'] . "</td>";
                                                
                                                echo "<td align='center'>
                                                          <form method='POST' action='updateArticle.php'>
                                                              <input type='submit' name='update' value='Update'>
                                                              <input type='hidden' value='" . $offer['id'] . "' name='id'>
                                                          </form>
                                                      </td>";
                                                echo "<td><a href='deleteArticle.php?id=" . $offer['id'] . "'>Delete</a></td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </div>
    </div>
</div>
               
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Travel Booking 2024</span>
                        </div>
                    </div>
                </footer>
              
    
            </div>
         
    
        </div>
       
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <script src="js/addOffer.js"></script>
    
        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    
        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    
        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>
    
        <!-- Page level plugins -->
        <script src="vendor/chart.js/Chart.min.js"></script>
    
        <!-- Page level custom scripts -->
        <script src="js/demo/chart-area-demo.js"></script>
        <script src="js/demo/chart-pie-demo.js"></script>
    
    </body>

</html>
