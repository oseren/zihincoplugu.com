<?php include("include/config.php"); ?>
<?php include("session.php"); ?>
<?php include("func.php"); ?>
<?php checkSession(); ?>

<?php 

$sqlprofile = $config -> prepare("SELECT profilephoto FROM user WHERE user_id=?");
$sqlprofile -> bind_param("s",$_SESSION['userdata']['0']);
$sqlprofile -> execute();
$rowprofile = $sqlprofile -> get_result();
$resultprofile = $rowprofile -> fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Profil Fotoğrafı Değiştir • <?=$dataname["websitename"]?></title>
    <link rel="shortcut icon" href="../<?=$dataname["favicon"]?>">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">

    <link rel="stylesheet" href="../css/jquery.fancybox.min.css">
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
                                <h3 class="card-title">Profil Ayarları</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">

                                <form action="controller/profile_controller.php" method="post" enctype="multipart/form-data">

                                    <div class="row">

                                        <div class="col-md-9">
                                            <div class="form-group">

                                                <label>Profil Fotoğrafın</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="profilephoto">
                                                        <label class="custom-file-label" for="exampleInputFile">Dosya
                                                            Seç</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">

                                                <label>Şuanki Profile Fotoğrafın</label>
                                                <div class="isotope-card">
                                                    <a href="profiles/<?=$resultprofile["profilephoto"]?>" data-fancybox="gal">
                                                        <span class="input-group-text">Görmek için Tıkla</span>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <input type="submit" value="Kaydet" class="btn btn-primary">

                                </form>

                            </div>
                        </div>

                    </div>
                </section>
            </div>


            <script src="plugins/jquery/jquery.min.js"></script>
            <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

            <script src="dist/js/adminlte.min.js"></script>

            <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

            <script src="plugins/toastr/toastr.min.js"></script>
            <script src="../js/jquery.fancybox.min.js"></script>

            <?php 
            if (!empty($_SESSION["msg"])) {
                $toast_message = $_SESSION["msg"][0];
                $toast = $_SESSION["msg"][1];
                echo "<script type='text/javascript'>$toast('$toast_message')</script>";
            }
            unset($_SESSION['msg']);
        ?>

            <script>

            $(function() {
                bsCustomFileInput.init();
            });
            </script>

</body>

</html>