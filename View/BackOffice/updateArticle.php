<?php
include '../../controller/ArticlesController.php';
$error = "";
$articleC = new ArticlesController();

// Vérifier si l'ID est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Récupérer les données actuelles de l'article
    $currentArticle = $articleC->showArticle($id);
    if (!$currentArticle) {
        die("L'article n'existe pas.");
    }
} else {
    die("ID non spécifié.");
}

// Traitement de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST["titre"]) && !empty($_POST["titre"]) &&
        isset($_POST["contenu_txt"]) && !empty($_POST["contenu_txt"]) &&
        isset($_POST["date_creation"]) && !empty($_POST["date_creation"])
    ) {
        // Gestion de l'image
        if (isset($_FILES['contenu_img']) && $_FILES['contenu_img']['name'] != '') {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["contenu_img"]["name"]);
            move_uploaded_file($_FILES["contenu_img"]["tmp_name"], $target_file);
            $contenu_img = $target_file;
        } else {
            $contenu_img = $currentArticle['contenu_img']; // Conserver l'image existante
        }

        // Créer un nouvel objet Articles
        $updatedArticle = new Articles(
            $id,
            $_POST['titre'],
            $_POST['contenu_txt'],
            $contenu_img,
            new DateTime($_POST['date_creation'])
        );

        // Appeler la méthode de mise à jour
        $articleC->updateArticles($updatedArticle, $id);

        // Redirection vers la liste des articles
        header('Location: listArticles.php');
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>
<!--

=========================================================
* Now UI Dashboard - v1.5.0
=========================================================

* Product Page: https://www.creative-tim.com/product/now-ui-dashboard
* Copyright 2019 Creative Tim (http://www.creative-tim.com)

* Designed by www.invisionapp.com Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Now UI Dashboard by Creative Tim
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="user-profile">
  <div class="wrapper ">
    <div class="sidebar" data-color="orange">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          CT
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          Creative Tim
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li>
            <a href="index.php">
              <i class="now-ui-icons design_app"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="DataTable.php">
              <i class="now-ui-icons education_atom"></i>
              <p>Table</p>
            </a>
          </li>
          <li>
            <a href="AdminProfile.php">
              <i class="now-ui-icons location_map-big"></i>
              <p>Profile</p>
            </a>
          </li>
          <li>
            <a href="ajouterProduit.php">
              <i class="now-ui-icons ui-1_bell-53"></i>
              <p>Add event</p>
            </a>
          </li>
          <li>
            <a href="addArticle.php">
              <i class="now-ui-icons users_single-02"></i>
              <p>User Profile</p>
            </a>
          </li>
          <li class="active ">
            <a href="listArticles.php">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Tliste article</p>
            </a>
          </li>
          <li>
            <a href="pg.php">
              <i class="now-ui-icons text_caps-small"></i>
              <p>liste event </p>
            </a>
          </li>
          <li class="active-pro">
            <a href="../backend/Productlist.php">
              <i class="now-ui-icons arrows-1_cloud-download-93"></i>
              <p>liste produit</p>
            </a>
          </li>
          <li class="active-pro">
            <a href="../reclamations_manage.php">
              <i class="now-ui-icons arrows-1_cloud-download-93"></i>
              <p> reclamations manage</p>
            </a>
          </li>
          <li class="active-pro">
            <a href="">
              <i class="now-ui-icons arrows-1_cloud-download-93"></i>
              <p> Question</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo">User Profile</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="now-ui-icons ui-1_zoom-bold"></i>
                  </div>
                </div>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="now-ui-icons media-2_sound-wave"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Stats</span>
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="now-ui-icons location_world"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="now-ui-icons users_single-02"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Account</span>
                  </p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h5 class="title">Edit Profile</h5>
              </div>
              <div class="card-body">
              <form method="POST" enctype="multipart/form-data">
        <div>
            <label>ID (Non modifiable)</label>
            <input type="text" name="id" value="<?php echo htmlspecialchars($currentArticle['id']); ?>" readonly>
        </div>
        <div>
            <label>Titre</label>
            <input type="text" name="titre" value="<?php echo htmlspecialchars($currentArticle['titre']); ?>" required>
        </div>
        <div>
            <label>Contenu Texte</label>
            <textarea name="contenu_txt" required><?php echo htmlspecialchars($currentArticle['contenu_txt']); ?></textarea>
        </div>
        <div>
            <label>Image Actuelle</label><br>
            <img src="<?php echo htmlspecialchars($currentArticle['contenu_img']); ?>" alt="Image" style="width: 150px; height: auto;"><br>
            <label>Changer l'image</label>
            <input type="file" name="contenu_img">
        </div>
        <div>
            <label>Date de Création</label>
            <input type="date" name="date_creation" value="<?php echo htmlspecialchars($currentArticle['date_creation']); ?>" required>
        </div>
        <div>
            <button type="submit">Mettre à jour</button>
        </div>
    </form>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-user">
              <div class="image">
                <img src="assets/img/bg5.jpg" alt="...">
              </div>
              <div class="card-body">
                <div class="author">
                  <a href="#">
                    <img class="avatar border-gray" src="assets/img/mike.jpg" alt="...">
                    <h5 class="title">Mike Andrew</h5>
                  </a>
                  <p class="description">
                    michael24
                  </p>
                </div>
                <p class="description text-center">
                  "Lamborghini Mercy <br>
                  Your chick she so thirsty <br>
                  I'm in that two seat Lambo"
                </p>
              </div>
              <hr>
              <div class="button-container">
                <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                  <i class="fab fa-facebook-f"></i>
                </button>
                <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                  <i class="fab fa-twitter"></i>
                </button>
                <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                  <i class="fab fa-google-plus-g"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class=" container-fluid ">
          <nav>
            <ul>
              <li>
                <a href="https://www.creative-tim.com">
                  Creative Tim
                </a>
              </li>
              <li>
                <a href="http://presentation.creative-tim.com">
                  About Us
                </a>
              </li>
              <li>
                <a href="http://blog.creative-tim.com">
                  Blog
                </a>
              </li>
            </ul>
          </nav>
          <div class="copyright" id="copyright">
            &copy; <script>
              document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
            </script>, Designed by <a href="https://www.invisionapp.com" target="_blank">Invision</a>. Coded by <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a>.
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="assets/demo/demo.js"></script>
</body>

</html>