<?php include("../include/config.php"); ?>
<?php include("../session.php"); ?>
<?php checkSession(); ?>

<?php 
$_SESSION['msg'] = "";

if(!empty($_POST["islem"])) {
    $g_islem = $_POST["islem"];
}

if ($g_islem == "generalsettings") {

    if ($_SESSION["userdata"]["2"] == 1) {

        if (!empty($_POST["websitename"]) && isset($_FILES["favicon"])) {
    
            $websitename = mysqli_real_escape_string($config,$_POST['websitename']);
    
            $filename = $_FILES['favicon']['name'];
    
            $tmp_name = $_FILES['favicon']['tmp_name'];
    
            $size = $_FILES['favicon']['size'];
            $image_ext = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
    
            $new_name = "favicon.".$image_ext;
    
            
            $allow_type = ['jpg','png','jpeg'];
    
            $destination = "../../".$new_name;
    
            if (!empty($filename)) {
    
                $dimensions = getimagesize($tmp_name);
                $width = $dimensions[0];
                $height = $dimensions[1];
    
                if (in_array($image_ext, $allow_type)) {
    
                    if ($width == 32 && $height == 32) {
    
                        if ($size <= 2000000) {
    
                            $sql = $config -> prepare("SELECT favicon FROM main");
                            $sql -> execute();
            
                            $cevap = $sql -> get_result();
            
                            if($cevap -> num_rows > 0) {
                                while($veri = $cevap -> fetch_assoc()) {
                                    unlink("../../".$veri["favicon"]);
                                }
                            }
            
                            move_uploaded_file($tmp_name, $destination);
            
                            $sql2 = $config -> prepare("UPDATE main SET websitename=?, favicon=?");
                            $sql2 -> bind_param("ss",$websitename,$new_name);
                            $sql2 -> execute();
            
                                if ($sql2) {
                                        $_SESSION['msg']=['Genel ayarlar başarıyla güncellendi','toastr.success'];
                                        header("location: ../settings.php");
                                    } else {
                                        $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
                                        header("location: ../settings.php");
                                    }
                                } else {
                                    $_SESSION['msg']=['Resim boyutu 2mbdan büyük olmamalıdır','toastr.warning'];
                                    header("location: ../settings.php");
                                }
    
                    } else {
                        $_SESSION['msg']=['Resim boyutu 32x32 olmamalıdır','toastr.error'];
                        header("location: ../settings.php");
                    }
                
                    } else {
                    $_SESSION['msg']=['Dosya uzantısı olarak jpg, png ve jpeg desteklenmektedir','toastr.warning'];
                    header("location: ../settings.php");
                }
    
            } else {
    
                $sql3 = $config -> prepare("UPDATE main SET websitename=?");
                $sql3 -> bind_param("s",$websitename);
                $sql3 -> execute();
    
                if ($sql3) {
                    $_SESSION['msg']=['Genel ayarlar başarıyla güncellendi','toastr.success'];
                    header("location: ../settings.php");
                } else {
                    $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
                    header("location: ../settings.php");
                }
            }
        }
    
    } else {
        header("location: ../index.php");
    }
    
} elseif ($g_islem == "socialmedia") {

    if ($_SESSION["userdata"]["2"] == 1) {

        if (!empty($_POST["instagramlink"]) && !empty($_POST["twitterlink"]) && !empty($_POST["pinterestlink"])) {

            $instagramlink = mysqli_real_escape_string($config,$_POST['instagramlink']);
            $twitterlink = mysqli_real_escape_string($config,$_POST['twitterlink']);
            $pinterestlink = mysqli_real_escape_string($config,$_POST['pinterestlink']);

            $sql4 = $config -> prepare("UPDATE main SET instagramlink=?, twitterlink=?, pinterestlink=?");
            $sql4 -> bind_param("sss",$instagramlink,$twitterlink,$pinterestlink);
            $sql4 -> execute();

            if ($sql4) {
                $_SESSION['msg']=['Sosyal medya ayarları başarıyla güncellendi','toastr.success'];
                header("location: ../settings.php");
            } else {
                $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
                header("location: ../settings.php");
            }
            
        } else {
            $_SESSION['msg']=['İnstagram, Twitter, Pinterest alanları boş olamazs','toastr.warning'];
            header("location: ../settings.php");
        }
    
    } else {
        header("location: ../index.php");
    }


} else {
    $_SESSION['msg'] = ['Bir hata oluştu','toastr.error'];
    header("location: ../index.php");
}




?>