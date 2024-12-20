<!DOCTYPE html>
<html>
<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>List Questions</title>
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
            <!-- list question section start -->
            <div class="container">
                <h2>List of Questions</h2>
                <?php
                include_once '../../../controller/questionC.php';

                $questionC = new QuestionC();

                // Pagination logic
                $limit = 5; // Number of questions per page
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
                $page = $page < 1 ? 1 : $page; // Ensure page is at least 1
                $offset = ($page - 1) * $limit; // Offset calculation

                // Get the total number of questions
                $totalQuestions = $questionC->getQuestions()->rowCount(); // Assuming `getQuestions` retrieves all without limit
                $totalPages = ceil($totalQuestions / $limit); // Total number of pages

                // Fetch questions for the current page
                $stmt = $questionC->getQuestions($offset, $limit);

                // Display questions
                if ($stmt->rowCount() > 0) {
                    echo "<ul style='list-style-type: none; padding: 0;'>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li style='margin-bottom: 20px;'>
                                <span style='font-size: 1.2em; font-weight: bold;'>Question ID:</span> " . htmlspecialchars($row['id_question']) . "<br>
                                <span style='font-size: 1.2em; font-weight: bold;'>Title:</span> " . htmlspecialchars($row['titre']) . "<br>
                                <span style='font-size: 1.2em; font-weight: bold;'>Description:</span> " . htmlspecialchars($row['description']) . "<br>
                                <span style='font-size: 1.2em; font-weight: bold;'>Creation Date:</span> " . htmlspecialchars($row['date_creation']) . "<br>
                                <a href='modifyquestion.php?id=" . htmlspecialchars($row['id_question']) . "' class='btn btn-success' style='margin-right: 10px;'>Modify</a>
                                <a href='deletequestion.php?id=" . htmlspecialchars($row['id_question']) . "' class='btn btn-danger' onclick=\"return confirm('Are you sure you want to delete this question?')\">Delete</a>
                              </li><br>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No questions found.</p>";
                }

                // Display pagination
                if ($totalPages > 1) {
                    echo "<nav aria-label='Page navigation'>";
                    echo "<ul class='pagination justify-content-center'>";
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<li class='page-item " . ($i == $page ? "active" : "") . "'>
                                <a class='page-link' href='listquestion.php?page=$i'>$i</a>
                              </li>";
                    }
                    echo "</ul>";
                    echo "</nav>";
                }
                ?>
            </div>
            <!-- list question section end -->
        </div>
    </div>

    <!-- footer section start -->
    <div class="footer_section layout_padding">
        <div class="container">
            <!-- Add footer content here -->
        </div>
    </div>
    <!-- footer section end -->

    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/plugin.js"></script>
</body>
</html>
