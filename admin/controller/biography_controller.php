<?php include("../include/config.php"); ?>
<?php include("../session.php"); ?>
<?php checkSession(); ?>

<?php 
$_SESSION['msg'] = "";

if ($_SESSION["userdata"]["2"] == 1) {

    if (!empty($_POST["biography"]) && !empty($_POST["biographyname"]) && isset($_FILES["biographyimage"])) {

        $biography = $_POST['biography'];

        $biographyname = mysqli_real_escape_string($config,$_POST['biographyname']);

        $filename = $_FILES['biographyimage']['name'];
        $new_name = date("YdmHis").'_'.$filename;

        $tmp_name = $_FILES['biographyimage']['tmp_name'];

        $size = $_FILES['biographyimage']['size'];
        $image_ext = strtolower(pathinfo($new_name,PATHINFO_EXTENSION));
        $allow_type = ['jpg','png','jpeg'];
        $destination = "../pictures/".$new_name;

        if (!empty($filename)) {

            if (in_array($image_ext, $allow_type)) {
                
                if ($size <= 2000000) {

                $sql = $config -> prepare("SELECT biographyimage FROM main");
                $sql -> execute();

                $cevap = $sql -> get_result();

                if($cevap -> num_rows > 0) {
                    while($veri = $cevap -> fetch_assoc()) {
                        unlink("../pictures/".$veri["biographyimage"]);
                    }
                }

                move_uploaded_file($tmp_name, $destination);

                $sql2 = $config -> prepare("UPDATE main SET biography=?, biographyname=?, biographyimage=?");
                $sql2 -> bind_param("sss",$biography,$biographyname,$new_name);
                $sql2 -> execute();

                    if ($sql2) {
                            $_SESSION['msg']=['Biyografi başarıyla güncellendi','toastr.success'];
                            header("location: ../index.php");
                        } else {
                            $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
                            header("location: ../index.php");
                        }
                    } else {
                        $_SESSION['msg'] = ['Resim boyutu 2mbdan büyük olmamalıdır','toastr.warning'];
                        header("location: ../index.php");
                    }
                } else {
                $_SESSION['msg']=['Dosya uzantısı olarak jpg, png ve jpeg desteklenmektedir','toastr.warning'];
                header("location: ../index.php");
            }

        } else {

            $sql3 = $config -> prepare("UPDATE main SET biography=?, biographyname=?");
            $sql3 -> bind_param("ss",$biography,$biographyname);
            $sql3 -> execute();

            if ($sql3) {
                $_SESSION['msg']=['Biyografi başarıyla güncellendi','toastr.success'];
                header("location: ../index.php");
            } else {
                $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
                header("location: ../index.php");
            }
        }
    } else {
        $_SESSION['msg'] = ['İstenilen alanlar boş olamaz','toastr.error'];
        header("location: ../index.php");
    }

} else {
    $_SESSION['msg'] = ['Bir hata oluştu','toastr.error'];
    header("location: ../index.php");
}


?>