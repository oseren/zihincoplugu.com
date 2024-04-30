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

    <title>Kullanıcı Ekle • <?=$dataname["websitename"]?></title>
    <link rel="shortcut icon" href="../<?=$dataname["favicon"]?>">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">

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
                                <h3 class="card-title">Kullanıcı Ekleme Sayfası</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">

                                <form action="controller/users_controller.php" method="post">

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kullanıcı Adı</label>
                                                <input type="text" class="form-control" name="username"
                                                    placeholder="Kullanıcı Adı" required>
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kullanıcı Maili</label>
                                                <input type="email" class="form-control" name="email"
                                                    placeholder="Kullanıcı Maili" required>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kullanıcı Şifresi</label>
                                                <input type="password" class="form-control" name="password"
                                                    placeholder="Kullanıcı Şifresi" required>
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kullanıcı Rolü</label>
                                                <select class="form-control select2 select2-hidden-accessible"
                                                    data-minimum-results-for-search="Infinity" style="width: 100%;"
                                                    data-select2-id="1" tabindex="-1" aria-hidden="true" name="role"
                                                    required>

                                                    <option value="">Rol Seçin</option>
                                                    <option value="1">Admin</option>
                                                    <option value="0">Yazar</option>

                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <input type="submit" name="add_user" value="Kaydet" class="btn btn-primary">
                                    <input type="hidden" name="islem" value="add" class="btn btn-primary">

                                </form>

                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <script src="plugins/jquery/jquery.min.js"></script>
            <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

            <script src="plugins/select2/js/select2.full.min.js"></script>

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

            <script>
            $(function() {
                $('.select2').select2()

            });
            </script>
</body>

</html>