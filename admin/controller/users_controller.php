<?php include("../include/config.php"); ?>
<?php include("../session.php"); ?>
<?php checkSession(); ?>

<?php 

if(!empty($_POST["islem"])) {
    $g_islem = $_POST["islem"];
}

$_SESSION['msg'] = "";

if($g_islem == "add") {

    if ($_SESSION["userdata"]["2"] == 1) {
        if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])  && isset($_POST['role'])) {
        
            $username = mysqli_real_escape_string($config,$_POST['username']);
            $email = mysqli_real_escape_string($config,$_POST['email']);
            $pass = mysqli_real_escape_string($config,sha1($_POST['password']));
            $role = mysqli_real_escape_string($config,$_POST['role']);
        
            if (strlen($username) < 4 || strlen($username) > 50) {
    
                $_SESSION['msg'] = ['Kullanıcı ismi 4 - 50 karakter olmalıdır','toastr.warning'];
                header("location: ../users_add.php");
    
            } elseif (strlen($_POST['password']) < 4 ) {
    
                $_SESSION['msg'] = ['Parola 4 karakterden uzun olmalıdır','toastr.warning'];
                header("location: ../users_add.php");
    
            } else {
    
                $sql1 = $config -> prepare("SELECT * FROM user WHERE email=?");
                $sql1 -> bind_param("s",$email);
    
                $sql1 -> execute();
                $sql1 -> store_result();
    
                $sql1 -> fetch();
                $row = $sql1 -> num_rows;
                
                if ($row >= 1) {
    
                    $_SESSION['msg'] = ['Bu email zaten bulunmakta','toastr.warning'];
                    header("location: ../users_add.php");
    
                } else {
    
                    $sql2 = $config -> prepare("INSERT INTO user (username,email,password,role) VALUES(?,?,?,?)");
                    $sql2 -> bind_param("ssss",$username,$email,$pass,$role);
                    $sql2 -> execute();
    
                    if ($sql2) {
    
                        $_SESSION['msg'] = ['Kullanıcı başarıyla eklendi','toastr.success'];
                        header("location: ../users.php");
                    } else {
    
                        $_SESSION['msg'] = ['Bir hata oluştu','toastr.error'];
                        header("location: ../users.php");
                    }
                }
            }
        }
    } else {
        header("location: ../index.php");
    }

} elseif ($g_islem == "Sil") {

    if ($_SESSION["userdata"]["2"] == 1) {

        if (!empty($_POST['userid'])) {
            $id = $_POST['userid'];

            $sql3 = $config -> prepare("SELECT profilephoto FROM user WHERE user_id=?");
            $sql3 -> bind_param("s",$id);
            $sql3 -> execute();

            $cevap = $sql3 -> get_result();

            if($cevap -> num_rows > 0) {
                while($veri = $cevap -> fetch_assoc()) {
                    if (!($veri["profilephoto"] == "default_profile_photo.jpg")) {
                        echo($veri["profilephoto"]);
                        unlink("../profiles/".$veri["profilephoto"]);
                    }
                }
            }
    
            $sql4 = $config -> prepare("DELETE FROM user WHERE user_id=?");
            $sql4 -> bind_param("s",$id);
            $sql4 -> execute();
    
            if ($sql4) {
                
                $_SESSION['msg']=['Kullanıcı başarıyla silindi','toastr.success'];
                header("location: ../users.php");
            } else {
                $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
                header("location: ../users.php");
            }
         }

    } else {
        header("location: ../index.php");
    }

} else {
    
    $_SESSION['msg']=['Bir hata oluştu','toastr.error'];
    header("location: ../users.php");

}

?>