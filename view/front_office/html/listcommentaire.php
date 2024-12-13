<!DOCTYPE html>
<html lang="en">
<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>List Commentaires</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    
    <!-- Font CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,800&family=Sen:wght@400;700;800&display=swap" rel="stylesheet">
    
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
</head>
<body>
    <div class="header_section">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="index.html"><img src="images/logo.png" alt="logo"></a>
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
    
    <div class="container-fluid">
        <div class="layout_border">
            <div class="container">
                <h2>List of Commentaires</h2>

                <?php
                include_once '../../../controller/commentaireC.php';

                $commentaireC = new CommentaireC();
                $comments = $commentaireC->getCommentaires(); // Fetch all commentaires

                if ($comments) {
                    echo "<ul class='list-unstyled'>";
                    foreach ($comments as $row) {
                        // Sanitize output to avoid XSS
                        $id_commentaire = htmlspecialchars($row['id_commentaire']);
                        $contenu = htmlspecialchars($row['contenu']);
                        $date_creation_cm = htmlspecialchars($row['date_creation_cm']);
                        $id_question = htmlspecialchars($row['id_question']);

                        echo "<li class='mb-4'>
                                <div>
                                    <strong>Comment ID:</strong> $id_commentaire<br>
                                    <strong>Content:</strong> $contenu<br>
                                    <strong>Creation Date:</strong> $date_creation_cm<br>
                                    <strong>Question ID:</strong> $id_question<br>
                                </div>
                                <a href='modifycommentaire.php?id=$id_commentaire' class='btn btn-success mr-2'>Modify</a>
                                <a href='deletecommentaire.php?id=$id_commentaire' class='btn btn-danger' onclick=\"return confirm('Are you sure you want to delete this commentaire?')\">Delete</a>
                              </li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No commentaires found.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="footer_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <h3 class="footer_text">Useful links</h3>
                    <div class="footer_menu">
                        <ul>
                            <li class="active"><a href="index.html"><span class="angle_icon active"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Home</a></li>
                            <li><a href="about.html"><span class="angle_icon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> About</a></li>
                            <li><a href="services.html"><span class="angle_icon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Services</a></li>
                            <li><a href="domain.html"><span class="angle_icon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Domain</a></li>
                            <li><a href="testimonial.html"><span class="angle_icon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Testimonial</a></li>
                            <li><a href="contact.html"><span class="angle_icon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <h3 class="footer_text">Address</h3>
                    <div class="location_text">
                        <ul>
                            <li><a href="#"><span class="padding_left_10"><i class="fa fa-map-marker" aria-hidden="true"></i></span>It is a long established fact that a reader will be distracted</a></li>
                            <li><a href="#"><span class="padding_left_10"><i class="fa fa-phone" aria-hidden="true"></i></span>(+71) 1234567890</a></li>
                            <li><a href="#"><span class="padding_left_10"><i class="fa fa-envelope" aria-hidden="true"></i></span>demo@gmail.com</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <h3 class="footer_text">Find Us</h3>
                    <p class="dummy_text">more-or-less normal distribution</p>
                    <div class="social_icon">
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright_section">
        <div class="container">
            <p class="copyright_text">2023 All Rights Reserved. Design by <a href="https://html.design">Free html Templates</a></p>
        </div>
    </div>

    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/plugin.js"></script>
</body>
</html>
