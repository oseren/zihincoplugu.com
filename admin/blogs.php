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

    <title>Bloglar • <?=$dataname["websitename"]?></title>
    <link rel="shortcut icon" href="../<?=$dataname["favicon"]?>">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

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
                                            <td> <a href="blogs_add.php" class="btn btn-sm btn-success">Yeni Blog
                                                    Yaz</a>
                                            </td>
                                        </h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example2" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Blog Adı</th>
                                                    <th>Kategorisi</th>
                                                    <th>Yazarı</th>
                                                    <th>Tarih</th>
                                                    <th>İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 

                                            $sql = $config -> prepare("SELECT * FROM blog LEFT JOIN categories ON blog.category=categories.cat_id LEFT JOIN user ON blog.author_id=user.user_id ORDER BY blog.publish_date DESC");
                                            $sql -> execute();
                                            $rows = $sql -> get_result();

                                            ?>

                                                <?php
                                            if ($rows) {
                                                while($result = mysqli_fetch_assoc($rows)) { ?>
                                                <tr>
                                                    <td> <?= $result['blog_id'] ?> </td>
                                                    <td> <?= $result['blog_title'] ?> </td>
                                                    <td> <?= $result['cat_name'] ?> </td>
                                                    <td> <?= $result['username'] ?> </td>
                                                    <td> <?= date('M d Y',strtotime($result['publish_date'])) ?> </td>
                                                    <td>

                                                        <div style="display: flex; width: 150px">

                                                            <?php 

                                                            if ($result["active"]) { ?>

                                                            <a href="controller/blogs_controller.php?islem=active&id=<?= $result['blog_id'] ?>&status=0"
                                                                class="btn btn-sm btn-warning mr-1">Gizle</a>

                                                            <?php } else { ?>

                                                            <a href="controller/blogs_controller.php?islem=active&id=<?= $result['blog_id'] ?>&status=1"
                                                                class="btn btn-sm btn-warning mr-1">Göster</a>

                                                            <?php
                                                            }

                                                            ?>

                                                            <?php

                                                            $sqlCommentsButton = $config -> prepare("SELECT COUNT(*) > 0 AS result_exists FROM comments WHERE blogID=?");
                                                            $sqlCommentsButton->bind_param("s", $result["blog_id"]);
                                                            $sqlCommentsButton -> execute();
                                                            $rowsCommentsButton = $sqlCommentsButton -> get_result();
                                                            $rowsCommentsButton = mysqli_fetch_assoc($rowsCommentsButton);

                                                            if ($rowsCommentsButton["result_exists"]) { ?>

                                                            <a href="blog_comments.php?id=<?=$result["blog_id"]?>"
                                                                class="btn btn-sm btn-info mr-1">Yorumlar</a>
                                                            <?php                          
                                                            }          
                                                            ?>

                                                            <a href="blogs_edit.php?id=<?= $result['blog_id'] ?>"
                                                                class="btn btn-sm btn-success">Düzenle</a>

                                                            <?php
                                                                
                                                                if ($_SESSION["userdata"]["2"] == 1) { ?>

                                                            <form class="ml-1" action="controller/blogs_controller.php"
                                                                method="POST"
                                                                onsubmit="return confirm('Silmek istediğine emin misin?')">

                                                                <input type="hidden" name="blogID"
                                                                    value="<?= $result['blog_id'] ?>">

                                                                <input type="hidden" name="image"
                                                                    value="<?= $result['blog_image'] ?>">

                                                                <input type="submit" name="islem" value="Sil"
                                                                    class="btn btn-sm btn-danger">
                                                            </form>

                                                            <?php } ?>
                                                        </div>
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
                "searching": true,
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