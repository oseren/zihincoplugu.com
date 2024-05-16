<?php include("include/config.php"); ?>
<?php include("session.php"); ?>
<?php include("func.php"); ?>
<?php checkSession(); ?>

<?php 
if ($_SESSION["userdata"]["2"] == 0) {
    header("location: index.php");
}
?>

<?php 

$sql1 = $config -> prepare("SELECT websitename,instagramlink,twitterlink,pinterestlink,questionText FROM main");
$sql1 -> execute();
$row1 = $sql1 -> get_result();
$result = $row1 -> fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ayarlar • <?=$dataname["websitename"]?></title>
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
                                <h3 class="card-title">Genel Ayarlar</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">

                                <form action="controller/settings_controller.php" method="post" enctype="multipart/form-data">

                                    <div class="row">

                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Website Adı</label>
                                                <input type="text" class="form-control" name="websitename"
                                                    placeholder="Website Adı" value="<?=$result['websitename']?>"
                                                    autocomplete="off" required>
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="form-group">

                                                <label>Site İconu</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="favicon">
                                                        <label class="custom-file-label" for="exampleInputFile">Dosya
                                                            Seç</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">

                                                <label>Şuanki Site İconu</label>
                                                <div class="isotope-card">
                                                    <a href="../favicon.png" data-fancybox="gal">
                                                        <span class="input-group-text">Görmek için Tıkla</span>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <input type="submit" value="Kaydet" class="btn btn-primary">
                                    <input type="hidden" name="islem" value="generalsettings">

                                </form>

                            </div>
                        </div>

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Sosyal Medya Ayarları</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">

                                <form action="controller/settings_controller.php" method="post" enctype="multipart/form-data">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>İnstagram</label>
                                                <input type="text" class="form-control" name="instagramlink"
                                                    placeholder="Website Başlığı" value="<?=$result['instagramlink']?>"
                                                    autocomplete="off" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">

                                                <label>Twitter</label>
                                                <input type="text" class="form-control" name="twitterlink"
                                                    placeholder="Website Adı" value="<?=$result['twitterlink']?>"
                                                    autocomplete="off" required>

                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">

                                                <label>Pinterest</label>
                                                <input type="text" class="form-control" name="pinterestlink"
                                                    placeholder="Website Adı" value="<?=$result['pinterestlink']?>"
                                                    autocomplete="off" required>

                                            </div>

                                        </div>
                                    </div>

                                    <input type="submit" value="Kaydet" class="btn btn-primary">
                                    <input type="hidden" name="islem" value="socialmedia">

                                </form>

                            </div>
                        </div>

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Zihnini Boşalt Sayfası Ayarları</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">

                                <form action="controller/settings_controller.php" method="post">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Açıklama Metni</label>
                                                    <textarea class="form-control" placeholder="Zihnini Boşalt Sayfasındaki Açıklama Yazısı" name="questionText" required><?=$result['questionText']?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="submit" value="Kaydet" class="btn btn-primary">
                                    <input type="hidden" name="islem" value="questionpage">

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