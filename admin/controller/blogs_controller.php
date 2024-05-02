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

if($g_islem == "add") {

    if (!empty($_POST["blog_title"]) && !empty($_POST["blog_body"]) && !empty($_POST["category"]) && isset($_FILES["blog_image"])) {

        $title = mysqli_real_escape_string($config,$_POST['blog_title']);

        $body = $_POST['blog_body'];
        // $body = str_replace(array("\r", "\n"), '', $body);
        // $body = mysqli_real_escape_string($config, $body);

        $filename = $_FILES['blog_image']['name'];
        $new_name = date("YdmHis").'_'.$filename;

        $tmp_name = $_FILES['blog_image']['tmp_name'];
        $size = $_FILES['blog_image']['size'];

        $image_ext = strtolower(pathinfo($new_name,PATHINFO_EXTENSION));
        $allow_type = ['jpg','png','jpeg'];
        $destination = "../pictures/".$new_name;

        $author_id = $_SESSION['userdata']['0'];

        $category = mysqli_real_escape_string($config,$_POST['category']);

        if (in_array($image_ext, $allow_type)) {

            if ($size <= 2000000) {

                move_uploaded_file($tmp_name, $destination);

                $sql1 = $config -> prepare("INSERT INTO blog (blog_title,blog_body,blog_image,category,author_id) VALUES(?,?,?,?,?)");
                $sql1 -> bind_param("sssss",$title,$body,$new_name,$category,$author_id);
                // $query2 = mysqli_query($config,$sql2);
                $sql1 -> execute();
                
                if ($sql1) {

                    $_SESSION['msg']=['Blog Başarıyla Yayınlandı','toastr.success'];
                    header("location: ../blogs.php");

                } else {

                    $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
                    header("location: ../blogs_add.php");
                }

            } else {
                $_SESSION['msg']=['Resim boyutu 2mbdan büyük olmamalıdır','toastr.warning'];
                header("location: ../blogs_add.php");
            }
        } else {
            $_SESSION['msg']=['Dosya uzantısı olarak jpg, png ve jpeg desteklenmektedir','toastr.warning'];
            header("location: ../blogs_add.php");
        }
    } else {
        $_SESSION['msg']=['Alanlar Boş olamaz','toastr.error'];
        header("location: ../blogs_add.php");  
    }


} elseif ($g_islem == "update") {

    if (!empty($_POST["blogID"]) && !empty($_POST["blog_title"]) && !empty($_POST["blog_body"]) && !empty($_POST["category"]) && isset($_FILES["blog_image"])) {

        $blogID = $_POST['blogID'];

        $title = mysqli_real_escape_string($config,$_POST['blog_title']);

        $body = $_POST['blog_body'];
        // $body = str_replace(array("\r", "\n"), '', $body);
        // $body = mysqli_real_escape_string($config, $body);

        $filename = $_FILES['blog_image']['name'];
        $new_name = date("YdmHis").'_'.$filename;

        $tmp_name = $_FILES['blog_image']['tmp_name'];
        $size = $_FILES['blog_image']['size'];
        $image_ext = strtolower(pathinfo($new_name,PATHINFO_EXTENSION));
        $allow_type = ['jpg','png','jpeg'];
        $destination = "../pictures/".$new_name;
        $category = mysqli_real_escape_string($config,$_POST['category']);

        if (!empty($filename)) {

            if (in_array($image_ext, $allow_type)) {
                
                if ($size <= 2000000) {

                $sql = $config -> prepare("SELECT blog_image FROM blog WHERE blog_id=?");
                $sql -> bind_param("s",$blogID);
                $sql -> execute();

                $cevap = $sql -> get_result();

                if($cevap -> num_rows > 0) {
                    while($veri = $cevap -> fetch_assoc()) {
                        unlink("../pictures/".$veri["blog_image"]);
                    }
                }

                move_uploaded_file($tmp_name, $destination);

                $sql2 = $config -> prepare("UPDATE blog SET blog_title=?, blog_body=?, blog_image=?, category=? WHERE blog_id=?");
                $sql2 -> bind_param("sssss",$title,$body,$new_name,$category,$blogID);
                $sql2 -> execute();

                    if ($sql2) {
                            $_SESSION['msg']=['Blog Başarıyla Güncellendi','toastr.success'];
                            header("location: ../blogs.php");
                        } else {
                            $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
                            header("location: ../blogs.php");
                        }
                    } else {
                        $_SESSION['msg']=['Resim boyutu 2mbdan büyük olmamalıdır','toastr.warning'];
                        header("location: ../blogs.php");
                    }
                } else {
                $_SESSION['msg']=['Dosya uzantısı olarak jpg, png ve jpeg desteklenmektedir','toastr.warning'];
                header("location: ../blogs.php");
            }

        } else {

            $sql3 = $config -> prepare("UPDATE blog SET blog_title=?, blog_body=?, category=? WHERE blog_id=?");
            $sql3 -> bind_param("ssss",$title,$body,$category,$blogID);
            $sql3 -> execute();

            if ($sql3) {
                $_SESSION['msg']=['Blog Başarıyla Güncellendi','toastr.success'];
                header("location: ../blogs.php");
            } else {
                $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
                header("location: ../blogs.php");
            }
        }
    } else {
        $_SESSION['msg']=['Alanlar Boş olamaz','toastr.error'];
        header("location: ../blogs.php");  
    }
    
} elseif ($g_islem == "Sil") {

    if (!empty($_POST['blogID']) && isset($_POST['image'])) {
        
        $id = $_POST['blogID'];
        $image = "../pictures/".$_POST['image'];

        $sql4 = $config -> prepare("DELETE FROM blog WHERE blog_id=?");
        $sql4 -> bind_param("s",$id);
        $sql4 -> execute();
        
        if ($sql4) {
            unlink($image);
            $_SESSION['msg'] = ['Blog Başarıyla Silindi','toastr.success'];
            header("location: ../blogs.php");
        } else {
            $_SESSION['msg'] = ['Bir hata oluştu','toastr.error'];
            header("location: ../blogs.php");
            }
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

    } else if ($g_islem == "updatesettings") {

        if (!empty($_POST["blogID"]) && isset($_POST["durum"])) {

            $durum = $_POST["durum"];
            $blogID = $_POST["blogID"];

            $sql4 = $config -> prepare("UPDATE blog SET commentActive=? WHERE blog_id=?");
            $sql4 -> bind_param("ss",$durum,$blogID);
            $sql4 -> execute();
            
            $_SESSION['msg']=['Blog Yorumu Başarıyla Güncellendi','toastr.success'];
            header("location: ../blogs_edit.php?id=".$blogID);

        } else {

            $_SESSION['msg'] = ['Bir hata oluştu','toastr.error'];
            header("location: ../blogs.php");

        }

    } else {

        $_SESSION['msg'] = ['Bir hata oluştu','toastr.error'];
        header("location: ../blogs.php");

}

?>