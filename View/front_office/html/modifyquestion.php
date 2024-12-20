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
    <title>Modify Question</title>
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
                        <li class="nav-item">
                <a class="nav-link" href="questionpage.php">Question</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="commentairepage.php">Commentaire</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="listquestion.php">list questions</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="listcommentaire.php">list commentaires</a>
              </li>
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
            <!-- modify question section start -->
            <div class="container">
                <h2>Modify Question</h2>
                <?php
                include_once '../../../controller/questionC.php';

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];

                    $questionC = new QuestionC();
                    $question = $questionC->getQuestionById($id);

                    if ($question) {
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $titre = $_POST['titre'];
                            $description = $_POST['description'];
                            $date_creation = $_POST['date_creation'];

                            if ($questionC->modifierQuestion($id, $titre, $description, $date_creation)) {
                                echo "<script>
                                        alert('Question modified successfully!');
                                        window.location.href = 'listquestion.php';
                                      </script>";
                            } else {
                                echo "<script>alert('Unable to modify question.');</script>";
                            }
                        }
                        ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="titre">Title:</label>
                                <input type="text" class="form-control" id="titre" name="titre" value="<?php echo $question['titre']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $question['description']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="date_creation">Creation Date:</label>
                                <input type="date" class="form-control" id="date_creation" name="date_creation" value="<?php echo $question['date_creation']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        <?php
                    } else {
                        echo "<script>
                                alert('Question not found.');
                                window.location.href = 'listquestion.php';
                              </script>";
                    }
                } else {
                    echo "<script>
                            alert('Invalid request.');
                            window.location.href = 'listquestion.php';
                          </script>";
                }
                ?>
            </div>
            <!-- modify question section end -->
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
                            <li><a href="#"><span class="padding_left_10"><i class="fa fa-map-marker" aria-hidden="true"></i></span>It is a long established fact that a<br> reader will be distracted</a></li>
                            <li><a href="#"><span class="padding_left_10"><i class="fa fa-phone" aria-hidden="true"></i></span>(+71) 1234567890<br>(+71) 1234567890</a></li>
                            <li><a href="#"><span class="padding_left_10"><i class="fa fa-envelope" aria-hidden="true"></i></span>demo@gmail.com</a></li>
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
            </div>
        </div>
    </div>
    <!-- footer section end -->
    <!-- copyright section start -->
    <div class="copyright_section">
        <div class="container">
            <p class="copyright_text">2023 All Rights Reserved. Design by <a href="https://html.design">Free html  Templates</a></p>
        </div>
    </div>
    <!-- copyright section end -->
    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/plugin.js"></script>
</body>
</html>