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

if($g_islem == "confirm") {

    if (!empty($_GET["cid"]) && !empty($_GET['bid'])) {

        $commentsID = $_GET['cid'];
        $blogID = $_GET['bid'];

        $sqlConfirm = $config -> prepare("UPDATE comments SET status=? WHERE id=?");
        $status = 1;
        $sqlConfirm -> bind_param("ss",$status,$commentsID);
        $sqlConfirm -> execute();

        if ($sqlConfirm) {
            $_SESSION['msg']=['Yorum başarıyla onaylandı','toastr.success'];
            header("location: ../blog_comments.php?id=$blogID");
        } else {
            $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
            header("location: ../blog_comments.php?id=$blogID");
        }

    } else {
        $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
        header("location: ../blog_comments.php?id=$blogID"); 
    }

} elseif ($g_islem == "lastconfirm") {

    if (!empty($_GET["id"])) {

        $commentsID = $_GET['id'];
              
        $sqlConfirm = $config -> prepare("UPDATE comments SET status=? WHERE id=?");
        $status = 1;
        $sqlConfirm -> bind_param("ss",$status,$commentsID);
        $sqlConfirm -> execute();

        if ($sqlConfirm) {
            $_SESSION['msg']=['Yorum başarıyla onaylandı','toastr.success'];
            header("location: ../comments.php");
        } else {
            $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
            header("location: ../comments.php");
        }

    } else {
            $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
            header("location: ../comments.php"); 
        }
        
} elseif ($g_islem == "Sil") {

    if (!empty($_POST['id'])) {

        $id = $_POST['id'];

        $sqlDeleteComment = $config->prepare("DELETE FROM comments WHERE id = ?");
        $sqlDeleteComment->bind_param("s", $id);
        $sqlDeleteComment->execute();
    
        if ($sqlDeleteComment) {
            $_SESSION['msg'] = ['Yorum Başarıyla Silindi','toastr.success'];
            header("location: ../comments.php"); 
        } else {
            $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
            header("location: ../comments.php"); 
            }

    } else {
            $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
            header("location: ../comments.php"); 
        }
        
} elseif ($g_islem == "delete") {

    if (!empty($_POST["cid"]) && !empty($_POST['bid'])) {

        $commentsID = $_POST['cid'];
        $blogID = $_POST['bid'];
        
        function deleteComment($commentID,$blogID) {
            global $config;
        
            $sqlDeleteComment = $config->prepare("DELETE FROM comments WHERE id = ?");
            $sqlDeleteComment->bind_param("s", $commentID);
            $sqlDeleteComment->execute();
            
            $sqlSelectChildren = $config->prepare("SELECT id FROM comments WHERE parentID = ?");
            $sqlSelectChildren->bind_param("s", $commentID);
            $sqlSelectChildren->execute();
            $result = $sqlSelectChildren->get_result();
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    deleteComment($row['id'],$blogID);
                }
            }
        
            if ($sqlDeleteComment) {
                $_SESSION['msg'] = ['Yorum Başarıyla Silindi','toastr.success'];
                header("location: ../blog_comments.php?id=$blogID"); 
            } else {
                $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
                header("location: ../blog_comments.php?id=$blogID"); 
                }
        
        }        
    
        deleteComment($commentsID,$blogID);

    } else {
            $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
            header("location: ../blog_comments.php?id=$blogID"); 
        }
        
} elseif ($g_islem == "active") {

        if (!empty($_GET["id"]) && isset($_GET["status"])) {

            $id = $_GET["id"];
            $status = $_GET["status"];

            $sql4 = $config -> prepare("UPDATE blog SET active=? WHERE blog_id=?");
            $sql4 -> bind_param("ss",$status,$id);
            $sql4 -> execute();

            $_SESSION['msg']=['Blog Başarıyla Güncellendi','toastr.success'];
            header("location: ../blogs.php");
            
        } else {

            $_SESSION['msg'] = ['Bir hata oluştu','toastr.error'];
            header("location: ../blogs.php");

        }

    } else {

        $_SESSION['msg'] = ['Bir hata oluştu','toastr.error'];
        header("location: ../blogs.php");

}
?>