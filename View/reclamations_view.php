<?php
require_once '../config/DbConfig.php';
require_once '../controller/ReclamationController.php';

$reclamationController = new ReclamationController();
$reclamations = $reclamationController->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilisateurId = $_POST['utilisateurId'];
    $produitId = $_POST['produitId'];
    $content = $_POST['content']; 
    $note = $_POST['note'];
    $email = $_POST['email'];

    // Create the reclamation
    $reclamationController->create($utilisateurId, $produitId, $email, $note, $content);

    // Send email notification
    $to = $email; // Recipient's email
    $subject = "Reclamation Submitted";
    $message = "Your reclamation has been successfully submitted. Thank you!";
    $headers = "From: no-reply@example.com\r\n"; // Replace with your sender email

    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        // Email sent successfully
    } else {
        // Email sending failed
        echo "Email sending failed.";
    }

    header('Location: reclamations_view.php');
    exit();
}    

?>
<!DOCTYPE html>
<html>
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- site metas -->
      <title>Vagetables</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="../template/html/css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="../template/html/css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="../template/html/css/responsive.css">
      <!-- font css -->
      <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,800;1,400&family=Sen:wght@400;700;800&display=swap" rel="stylesheet">
      <style>
         @keyframes fadeIn {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

      .product-image {
         max-width: 100%; /* You can adjust the width as needed */
         height: auto;
         border-radius: 8px;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
         display: block;
         margin-left: 375px;
         margin-right: 0; /* Align to the right */
         margin-top: 70px; /* Move it further down */
         margin-bottom: 30px;
         animation: fadeIn 2s ease-out;
}
@keyframes slideText {
    0% {
        transform: translateX(-100%);
        opacity: 0;
    }
    100% {
        transform: translateX(0);
        opacity: 1;
    }
}
        }
        .product-header h1 {
            color: #232b2b;
            font-weight: 700;
            text-align: center;
            font-size: 2.5rem;
            margin-top: 20px;
        }
        .form-section h2 {
            color:#232b2b;
            font-weight: 700;
            font-size: 2rem;
            text-align: center;
            margin-bottom: 30px;
            animation: slideText 1s ease-out;
        }
        .form-section label {
            font-weight: 600;
            color: #34495e;
        }
        .form-section .form-control {
            border-radius: 5px;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
        }
        .form-section textarea {
            height: 150px;
        }
        .star-rating {
            text-align: center;
            font-size: 30px;
            margin-bottom: 20px;
            direction: rtl;
        }

        .star-rating label {
            cursor: pointer;
            color: lightgray;
        }

        .star-rating input {
            display: none;
        }

        .star-rating input:checked ~ label {
            color: gold;
        }

        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: gold;
        }
        .star-rating input:checked ~ label {
    color: gold;
    transform: scale(1.2); /* Slightly enlarge the selected stars */
    transition: transform 0.2s ease-in-out;
}

.star-rating label:hover,
.star-rating label:hover ~ label {
    color: gold;
    transform: scale(1.2);
    transition: transform 0.2s ease-in-out;
}


        .btn-warning {
            background-color: #00a877;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            padding: 10px 20px;
            text-transform: uppercase;
            width: 50%;
            margin-bottom: 30px;
            margin-left: 270px;
        }
        .btn-warning:hover {
            background-color: #e67e22;
        }
        body {
    background: linear-gradient(to right, #e9ffdb ,#a3c1ad  ); 
    background-size: cover;
}
.reclamation-section {
    margin-top: 50px;
    padding: 20px;
}

.reclamation-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.reclamation-card:hover {
    background-color: #eaf2f1;
    transform: scale(1.02);
    transition: all 0.3s ease;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 700;
}

.card-text {
    font-size: 1rem;
    color: #555;
}

.btn-success {
    width: auto;
    margin-left: 0;
}

      </style>
   </head>
   <body>
      <!-- header section start -->
      <div class="header_section">
         <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <a class="navbar-brand" href="index.html"><img src="../template/html/images/logo.png"></a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ml-auto">


                     <li class="nav-item">
                     <a class="nav-link" href="front_office/html/index.html">home</a>
                     </li>
                  
                     <li class="nav-item">
                     <a class="nav-link" href="frontOffice2/index.php">event</a>
                     </li>
                  
                  
                     <li class="nav-item">
                        <a class="nav-link" href="front_office/html/questionpage.php">question</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="FrontEnd/index.php">cart</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="Frontoffice/ArticlesList.php">article</a>
                     </li>
                    
                     <li class="nav-item">
                        <a class="nav-link" href="reclamations_view.php">reclamation </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="frontOffice2/profile.php">profile </a>
                     </li>
                  </ul>
                  <form class="form-inline my-2 my-lg-0">
                     <div class="search_icon"><i class="fa fa-search" aria-hidden="true"></i></div>
                  </form>
               </div>
            </nav>
         </div>
      </div>
      <!-- header section end -->

      <!-- layout_border start -->
      <div class="container-fluid">
      <div class="container">

        <!-- Product Details Section -->
        <div class="row">
            <div class="col-md-4">
                <img src="../template/html/images/PICREC.jpg" alt="Product Image" class="product-image">
            </div>
        </div>

        <!-- Form Section -->
        <div id="submit-reclamation-form" class="form-section">    
        <div class="form-section">
            <h2 class="text-secondary">Submit a Reclamation</h2>
            <form action="" method="post" class="mt-4">
                <div class="mb-3">
                    <label for="utilisateurId" class="form-label">Utilisateur ID:</label>
                    <input type="number" name="utilisateurId" id="utilisateurId" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="produitId" class="form-label">Produit ID:</label>
                    <input type="number" name="produitId" id="produitId" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea name="content" class="form-control" id="description" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">Note:</label>
                    <div class="star-rating">
                        <input type="radio" id="star5" name="note" value="5" required>
                        <label for="star5" title="5 stars">★</label>
                        <input type="radio" id="star4" name="note" value="4">
                        <label for="star4" title="4 stars">★</label>
                        <input type="radio" id="star3" name="note" value="3">
                        <label for="star3" title="3 stars">★</label>
                        <input type="radio" id="star2" name="note" value="2">
                        <label for="star2" title="2 stars">★</label>
                        <input type="radio" id="star1" name="note" value="1">
                        <label for="star1" title="1 star">★</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning">Submit</button>
<!-- Check Reclamation Status Button -->
<div class="text-left">
   <a href="check_status.php" class="btn btn-warning mt-3 ml-15">Check Reclamation Status</a>
</div>

<!-- List of Reclamations -->
<div class="reclamation-section">
    <h2 class="text-secondary text-center mb-4">List of Reclamations</h2>
    <a href="#submit-reclamation-form" class="btn btn-success mb-3">Add New Reclamation</a>
    <div class="reclamation-list">
        <?php foreach ($reclamations as $reclamation): ?>
            <div class="reclamation-card mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Reclamation ID: <?= $reclamation->getId() ?></h5>
                        <p class="card-text">
                            <strong>Utilisateur ID:</strong> <?= $reclamation->getUtilisateurId() ?><br>
                            <strong>Produit ID:</strong> <?= $reclamation->getProduitId() ?><br>
                            <strong>Description:</strong> <?= $reclamation->getContent() ?><br>
                            <strong>Note:</strong> <?= $reclamation->getNote() ?><br>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


            </form>
        </div>
      </div>
      </div>
      <!-- footer section start -->
     <!-- copyright section start -->
     <div class="copyright_section">
         <div class="container">
            <p class="copyright_text">2023 All Rights Reserved. Design by <a href="https://html.design">Free html  Templates</a></p>
         </div>
      </div>
      <!-- copyright section end -->

      <!-- Javascript files-->
      <script src="../template/html/js/jquery.min.js"></script>
      <script src="../template/html/js/popper.min.js"></script>
      <script src="../template/html/js/bootstrap.bundle.min.js"></script>
      <script src="../template/html/js/jquery-3.0.0.min.js"></script>
      <script src="../template/html/js/plugin.js"></script>
      <script>
window.embeddedChatbotConfig = {
chatbotId: "OghrLggZR1nporB9AQwu0",
domain: "www.chatbase.co"
}
</script>
<script
src="https://www.chatbase.co/embed.min.js"
chatbotId="OghrLggZR1nporB9AQwu0"
domain="www.chatbase.co"
defer>
</script>
   </body>
</html>  
