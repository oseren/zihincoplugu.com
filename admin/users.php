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

    <title>Kullanıcılar • <?=$dataname["websitename"]?></title>
    <link rel="shortcut icon" href="../<?=$dataname["favicon"]?>">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

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
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <td> <a href="users_add.php" class="btn btn-sm btn-success">Yeni Kullanıcı
                                                    Ekle</a>
                                            </td>
                                        </h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example2" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Kullanıcı Adı</th>
                                                    <th>Kullanıcı Maili</th>
                                                    <th>Kullanıcı Rolü</th>
                                                    <th>İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 

                                            $sql1 = $config -> prepare("SELECT * FROM user");
                                            $sql1 -> execute();
                                            $rows = $sql1 -> get_result();
                                            ?>

                                                <?php
                                            if ($rows) {
                                                while($result = mysqli_fetch_assoc($rows)) { ?>
                                                <tr>
                                                    <td> <?= $result['user_id'] ?> </td>
                                                    <td> <?= $result['username'] ?> </td>
                                                    <td> <?= $result['email'] ?> </td>
                                                    <td>
                                                        <?php
                                                        $role = $result['role'];

                                                        if($role == 1) {
                                                        echo "Admin";
                                                        } else {
                                                            echo "Yazar";
                                                        }?>
                                                    </td>

                                                    <td>
                                                        <form action="controller/users_controller.php" method="POST"
                                                            onsubmit="return confirm('Silmek istediğine emin misin?')">
                                                            <input type="hidden" name="userid"
                                                                value="<?= $result['user_id'] ?>">
                                                            <input type="submit" name="islem" value="Sil"
                                                                class="btn btn-sm btn-danger">
                                                        </form>
                                                    </td>

                                                </tr>
                                                <?php
                                                }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </section>
        </div>


        
        <script src="plugins/jquery/jquery.min.js"></script>
        
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        
        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
        <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
        <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
        <script src="plugins/toastr/toastr.min.js"></script>

        
        <script src="dist/js/adminlte.min.js"></script>

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
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": true,
                "pageLength": 6,
            });
        });
        </script>

</body>

</html>