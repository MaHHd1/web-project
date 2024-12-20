<!DOCTYPE html>
<html>
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Commentaire Page</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- font css -->
      <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,800&family=Sen:wght@400;700;800&display=swap" rel="stylesheet">
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   </head>
   <body>
      <div class="header_section">
         <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <a class="navbar-brand" href="index.html"><img src="images/logo.png"></a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ml-auto">
                     <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                     <li class="nav-item"><a class="nav-link" href="questionpage.php">Question</a></li>
                     <li class="nav-item"><a class="nav-link" href="commentairepage.php">Commentaire</a></li>
                     <li class="nav-item"><a class="nav-link" href="listquestion.php">List Questions</a></li>
                     <li class="nav-item"><a class="nav-link" href="listcommentaire.php">List Commentaires</a></li>
                     <li class="nav-item"><a class="nav-link" href="contact.html">Contact Us</a></li>
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
         <div class="layout_border">
            <!-- add commentaire section start -->
            <div class="container">
               <h2>Questions</h2>
               <?php
               include_once '../../../controller/questionC.php';
               include_once '../../../controller/commentaireC.php';

               $questionC = new QuestionC();
               $stmt = $questionC->getQuestions();

               echo "<ul>";
               while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                   echo "<li>Question ID: " . $row['id_question'] . " - Title: " . $row['titre'] . " - Description: " . $row['description'] . "</li>";
               }
               echo "</ul>";

               $commentaireC = new CommentaireC();

               if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                   $contenu = $_POST['contenu'];
                   $date_creation_cm = $_POST['date_creation_cm'];
                   $id_question = $_POST['id_question'];
                   $recipientEmail = isset($_POST['email']) ? $_POST['email'] : null; // Check for the email key

                   // Check if the entered question ID exists in the database
                   $questionExists = false;
                   $stmt = $questionC->getQuestions();
                   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                       if ($row['id_question'] == $id_question) {
                           $questionExists = true;
                           break;
                       }
                   }

                   if ($questionExists) {
                       if ($commentaireC->ajouterCommentaire($contenu, $date_creation_cm, $id_question, $recipientEmail)) {
                           echo "<script>alert('Commentaire added successfully!');</script>";
                       } else {
                           echo "<script>alert('Unable to add commentaire.');</script>";
                       }
                   } else {
                       echo "<script>alert('This question ID is not in the list.');</script>";
                   }
               }
               ?>
               <h2>Add a New Commentaire</h2>
               <form action="" method="post">
                  <div class="form-group">
                     <label for="id_question">Question ID:</label>
                     <input type="text" class="form-control" id="id_question" name="id_question" required>
                  </div>
                  <div class="form-group">
                     <label for="contenu">Content:</label>
                     <textarea class="form-control" id="contenu" name="contenu" rows="4" required></textarea>
                  </div>
                  <div class="form-group">
                     <label for="date_creation_cm">Creation Date:</label>
                     <input type="date" class="form-control" id="date_creation_cm" name="date_creation_cm" required>
                  </div>
                  <div class="form-group">
                     <label for="email">Recipient Email:</label>
                     <input type="email" class="form-control" id="email" name="email" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
               </form>
            </div>
            <!-- add commentaire section end -->
         </div>
      </div>
      <!-- footer section start -->
      <div class="footer_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-lg-4 col-sm-6">
                  <h3 class="footer_text">Useful links</h3>
                  <div class="footer_menu">
                     <ul>
                        <li class="active"><a href="index.html"><span class="angle_icon active"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Home</a></li>
                        <li><a href="about.html"><span class="angle_icon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>  About</a></li>
                        <li><a href="services.html"><span class="angle_icon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Services</a></li>
                        <li><a href="domain.html"><span class="angle_icon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Domain</a></li>
                        <li><a href="testimonial.html"><span class="angle_icon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>  Testimonial</a></li>
                        <li><a href="contact.html"><span class="angle_icon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>  Contact Us</a></li>
                     </ul>
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6">
                  <h3 class="footer_text">Address</h3>
                  <div class="location_text">
                     <ul>
                        <li>
                           <a href="#">
                           <span class="padding_left_10"><i class="fa fa-map-marker" aria-hidden="true"></i></span>It is a long established fact that a<br> reader will be distracted</a>
                        </li>
                        <li>
                           <a href="#">
                           <span class="padding_left_10"><i class="fa fa-phone" aria-hidden="true"></i></span>(+71) 1234567890<br>(+71) 1234567890
                           </a>
                        </li>
                        <li>
                           <a href="#">
                           <span class="padding_left_10"><i class="fa fa-envelope" aria-hidden="true"></i></span>demo@gmail.com
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6">
                  <div class="footer_main">
                     <h3 class="footer_text">Find Us</h3>
                     <p class="dummy_text">more-or-less normal distribution </p>
                     <div class="social_icon">
                        <ul>
                           <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                           <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                           <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div
