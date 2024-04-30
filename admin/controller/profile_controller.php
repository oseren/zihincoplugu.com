<?php include("../include/config.php"); ?>
<?php include("../session.php"); ?>
<?php checkSession(); ?>

<?php 

$_SESSION['msg'] = "";

if (isset($_FILES["profilephoto"])) {

    $filename = $_FILES['profilephoto']['name'];
    $file_ext = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
    $new_name = $_SESSION['userdata']['0'].'_'."profilephoto.".$file_ext;

    $tmp_name = $_FILES['profilephoto']['tmp_name'];
    $size = $_FILES['profilephoto']['size'];
    $image_ext = strtolower(pathinfo($new_name,PATHINFO_EXTENSION));
    $allow_type = ['jpg','png','jpeg'];
    $destination = "../profiles/".$new_name;

    if (!empty($filename)) {

        if (in_array($image_ext, $allow_type)) {
            
            if ($size <= 2000000) {

            $sql = $config -> prepare("SELECT profilephoto FROM user WHERE user_id=?");
            $sql -> bind_param("s",$_SESSION['userdata']['0']);
            $sql -> execute();

            $cevap = $sql -> get_result();

            if($cevap -> num_rows > 0) {
                while($veri = $cevap -> fetch_assoc()) {
                    if (!($veri["profilephoto"] == "default_profile_photo.jpg")) {
                        unlink("../profiles/".$veri["profilephoto"]);
                    }
                }
            }

            move_uploaded_file($tmp_name, $destination);

            $sql2 = $config -> prepare("UPDATE user SET profilephoto=? WHERE user_id=?");
            $sql2 -> bind_param("ss",$new_name,$_SESSION['userdata']['0']);
            $sql2 -> execute();

                if ($sql2) {
                        $_SESSION['msg']=['Profile fotoğrafı başarıyla güncellendi','toastr.success'];
                        header("location: ../index.php");
                    } else {
                        $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
                        header("location: ../index.php");
                    }
                } else {
                    $_SESSION['msg']=['Resim boyutu 2mbdan büyük olmamalıdır','toastr.warning'];
                    header("location: ../index.php");
                }
            } else {
            $_SESSION['msg']=['Dosya uzantısı olarak jpg, png ve jpeg desteklenmektedir','toastr.warning'];
            header("location: ../index.php");
        }

    } else {
        $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
        header("location: ../index.php");
    }
} else {
    $_SESSION['msg']=['Resim boş olamaz','toastr.error'];
    header("location: ../index.php");  
}

?>