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

        if (!empty($_POST['cat_name'])) {
            $cat_name = mysqli_real_escape_string($config,$_POST['cat_name']);
    
            $sql1 = $config -> prepare("SELECT * FROM categories WHERE cat_name=?");
            $sql1 -> bind_param("s",$cat_name);
    
            $sql1 -> execute();
            $sql1 -> store_result();
    
            $sql1 -> fetch();
            $row = $sql1 -> num_rows;
    
            if ($row) {
                $_SESSION['msg']=['Bu isimli kategori bulunmakta','toastr.warning'];
                header("location: ../category_add.php");
        
            } else {
    
                $sql2 = $config -> prepare("INSERT INTO categories (cat_name) VALUES(?)");
                $sql2 -> bind_param("s",$cat_name);
                $sql2 -> execute();
    
                if ($sql2) {
                    $_SESSION['msg'] = ['Kategori Başarıyla Eklendi','toastr.success'];
                    header("location: ../category.php");
                } else {
                    $_SESSION['msg'] = ['Bir hata oluştu','toastr.error'];
                    header("location: ../category.php");
                }
            }
        }

    } else {
        header("location: ../index.php");
    }

} elseif ($g_islem == "update") {

    if ($_SESSION["userdata"]["2"] == 1) {

        if (!empty($_POST['cat_name']) && isset($_POST['catID'])) {
            $cat_name = mysqli_real_escape_string($config,$_POST['cat_name']);
            $catID = mysqli_real_escape_string($config,$_POST['catID']);
    
            $sql3 = $config -> prepare("UPDATE categories SET cat_name=? WHERE cat_id=?");
            $sql3 -> bind_param("ss",$cat_name,$catID);
            $sql3 -> execute();
    
            if ($sql3) {
    
                $_SESSION['msg'] = ['Kategori Başarıyla Güncellendi','toastr.success'];
                header("location: ../category.php");
            } else {
                $_SESSION['msg'] = ['Bir hata oluştu','toastr.error'];
                header("location: ../category.php");
            }
        }
        
    } else {
        header("location: ../index.php");
    }

} elseif ($g_islem == "Sil") {

    if ($_SESSION["userdata"]["2"] == 1) {

        if (!empty($_POST['catID'])) {

            $id = $_POST['catID'];
    
            $sql4 = $config -> prepare("DELETE FROM categories WHERE cat_id=?");
            $sql4 -> bind_param("s",$id);
            $sql4 -> execute();
    
            if ($sql4) {
                $_SESSION['msg'] = ['Kategori Başarıyla Silindi','toastr.success'];
                header("location: ../category.php");
            } else {
                $_SESSION['msg'] = ['Bir hata oluştu','toastr.error'];
                header("location: ../category.php");
            }
         }
        
    } else {
        header("location: ../index.php");
    }

} else {
    $_SESSION['msg'] = ['Bir hata oluştu','toastr.error'];
    header("location: ../category.php");
}

?>