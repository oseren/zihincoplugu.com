<?php include("../include/config.php"); ?>
<?php include("../session.php"); ?>
<?php checkSession(); ?>

<?php 

if(!empty($_POST["islem"])) {
    $g_islem = $_POST["islem"];
} elseif(!empty($_GET["islem"])) {
    $g_islem = $_GET["islem"];
}

$_SESSION['msg'] = "";

if($g_islem == "answer") {

    if (!empty($_POST["questionID"]) && !empty($_POST['answer'])) {

        $questionID = $_POST["questionID"];
        $answer = $_POST['answer'];

        $sqlAnswerQuestion = $config->prepare("UPDATE questions SET answer=? WHERE id=?");
        $sqlAnswerQuestion->bind_param("ss", $answer,$questionID);
        $sqlAnswerQuestion->execute();

        if ($sqlAnswerQuestion) {
            echo '
            <div class="timeline-item mt-2">
                <h3 class="timeline-header">
                    '.$answer.'
                </h3>
            </div>
            ';
        } else {
            $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
            header("location: ../questions.php");
        }

    } else {
        $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
        header("location: ../questions.php"); 
    }

} elseif ($g_islem == "active") {

    if (!empty($_GET["id"]) && isset($_GET["status"])) {

        $id = $_GET["id"];
        $status = $_GET["status"];

        $sql4 = $config -> prepare("UPDATE questions SET active=? WHERE id=?");
        $sql4 -> bind_param("ss",$status,$id);
        $sql4 -> execute();

        $_SESSION['msg']=['Soru Başarıyla Güncellendi','toastr.success'];
        header("location: ../questions.php");
        
    } else {

        $_SESSION['msg'] = ['Bir hata oluştu','toastr.error'];
        header("location: ../questions.php");

    }

} elseif ($g_islem == "Sil") {

    if (!empty($_POST['id'])) {

        $id = $_POST['id'];

        $sqlDeleteQuestion = $config->prepare("DELETE FROM questions WHERE id = ?");
        $sqlDeleteQuestion->bind_param("s", $id);
        $sqlDeleteQuestion->execute();
    
        if ($sqlDeleteQuestion) {
            $_SESSION['msg'] = ['Soru Başarıyla Silindi','toastr.success'];
            header("location: ../questions.php"); 
        } else {
            $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
            header("location: ../questions.php"); 
            }

    } else {
            $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
            header("location: ../questions.php"); 
        }
        
} else {

        $_SESSION['msg'] = ['Bir hata oluştu','toastr.error'];
        header("location: ../questions.php");

}
?>

