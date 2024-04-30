<?php include("include/config.php"); ?>
<?php include("session.php"); ?>
<?php include("func.php"); ?>
<?php checkSession(); ?>

<?php 
if ($_SESSION["userdata"]["2"] == 0) {
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kategori Ekle • <?=$dataname["websitename"]?></title>
    <link rel="shortcut icon" href="../<?=$dataname["favicon"]?>">


    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include("include/navbar.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <?php include("include/sidebar.php"); ?>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">


                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Kategori Ekleme Sayfası</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">

                                <form action="controller/category_controller.php" method="post">

                                    <div class="row">
                                        <div class="col-12 col-sm-12">
                                            <div class="form-group">
                                                <label>Kategori Adı</label>
                                                <input type="text" class="form-control" name="cat_name"
                                                    placeholder="Kategori Adı" required>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="submit" name="add_cat" value="Kaydet" class="btn btn-primary">
                                    <input type="hidden" name="islem" value="add" class="btn btn-primary">

                                </form>

                            </div>
                        </div>
                    </div>
                </section>
            </div>

            
            <script src="plugins/jquery/jquery.min.js"></script>
            <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            
            <script src="dist/js/adminlte.min.js"></script>
            
            <script src="plugins/toastr/toastr.min.js"></script>

            <?php 
            if (!empty($_SESSION["msg"])) {
                $toast_message = $_SESSION["msg"][0];
                $toast = $_SESSION["msg"][1];
                echo "<script type='text/javascript'>$toast('$toast_message')</script>";
            }
            unset($_SESSION['msg']);
            ?>
</body>

</html>