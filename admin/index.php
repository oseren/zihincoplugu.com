<?php include("include/config.php"); ?>
<?php include("session.php"); ?>
<?php include("func.php"); ?>
<?php checkSession(); ?>

<?php 
if (isset($_SESSION['userdata'])) {
  $userID=$_SESSION['userdata']['0'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Paneli • <?=$dataname["websitename"]?></title>
    <link rel="shortcut icon" href="../<?=$dataname["favicon"]?>">


    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php include("include/navbar.php"); ?>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <?php include("include/sidebar.php"); ?>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">İstatistikler</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-feather"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Bloglar</span>
                                    <span class="info-box-number"><?=$resultcount["blog_count"]?></span>
                                </div>
                            </div>
                        </div>
                        <?php  
                        if ($_SESSION["userdata"]["2"] == 1) { ?>

                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-list"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Kategoriler</span>
                                    <span class="info-box-number"><?=$resultcount["category_count"]?></span>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-users"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Kullanıcılar</span>
                                    <span class="info-box-number"><?=$resultcount["user_count"]?></span>
                                </div>
                            </div>
                        </div>

                        <?php } ?>
                    </div>
                </div>
            </div>
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