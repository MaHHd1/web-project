<?php
include_once '../../../controller/questionC.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $questionC = new QuestionC();
    if ($questionC->deleteQuestion($id)) {
        echo "<script>
                alert('Question deleted successfully!');
                window.location.href = 'listquestion.php';
              </script>";
    } else {
        echo "<script>
                alert('Unable to delete question.');
                window.location.href = 'listquestion.php';
              </script>";
    }
}
?>
