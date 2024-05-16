<?php include("include/config.php"); ?>
<?php include("session.php"); ?>
<?php include("func.php"); ?>
<?php include("../include/commentsFunc.php"); ?>
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

    <title>Yorum Yönetimi • <?=$dataname["websitename"]?></title>
    <link rel="shortcut icon" href="../<?=$dataname["favicon"]?>">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

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
                                    <div class="card-header d-flex p-0">
                                        <h3 class="card-title p-3">Yorum Kontrol Sistemi</h3>
                                        <ul class="nav nav-pills ml-auto p-2">
                                            <li class="nav-item"><a class="nav-link active" href="#tab_1"
                                                    data-toggle="tab">Son Gelen Yorumlar</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Tüm
                                                    Yorumlar</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#tab_3"
                                                    data-toggle="tab">Bloglara Ayrılmış Yorumlar</a></li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">

                                            <div class="tab-pane active" id="tab_1">

                                                <?php 
                                                
                                                $sqlPendingApproval = $config -> prepare("SELECT c.*, b.blog_title, b.blog_id
                                                FROM comments c
                                                JOIN blog b ON c.blogID = b.blog_id WHERE status=0
                                                ORDER BY c.submitDate DESC");
                                                $sqlPendingApproval -> execute();
                                                $rowsPendingApproval = $sqlPendingApproval -> get_result();

                                                $currentBlogName = null;
                                                ?>

                                                <?php 
                                                
                                                if (mysqli_num_rows($rowsPendingApproval) != 0) { ?>
                                                <div class="timeline timeline-inverse">
                                                    <?php 
                                                    while ($resultPA = mysqli_fetch_assoc($rowsPendingApproval)) {
                                                        $varBlogName = $resultPA["blog_title"];

                                                        if ($varBlogName !== $currentBlogName) {
                                                            $currentBlogName = $varBlogName;
                                                    ?>

                                                    <div class="time-label">
                                                        <span class="bg-danger">
                                                            <?= $currentBlogName ?>
                                                        </span>
                                                    </div>

                                                    <?php
                                                        }
                                                    ?>

                                                    <div>
                                                        <i class="fas fa-comments bg-warning"></i>
                                                        <div class="timeline-item">
                                                            <span
                                                                class="time"><?=time_elapsed_string($resultPA["submitDate"])?>
                                                            </span>
                                                            <h3 class="timeline-header">
                                                                <?php  
                                                                $sqlAltComments = $config -> prepare("SELECT name FROM comments WHERE id=?");
                                                                
                                                                $sqlAltComments -> bind_param("s",$resultPA["parentID"]);
                                                                $sqlAltComments -> execute();
                                                                $rowAltComments = $sqlAltComments -> get_result();
                                                                $altComments = $rowAltComments -> fetch_assoc();
                                                                ?>

                                                                <?php 
                                                                if ($resultPA["parentID"] != 0) { ?>

                                                                <a><?=$resultPA["name"]?></a> adlı kişi
                                                                <a><?=$altComments["name"]?></a> adlı kişiye cevap yazdı

                                                                <?php
                                                                } else { ?>

                                                                <a><?=$resultPA["name"]?></a> adlı kişi yorum yaptı
                                                                <?php
                                                                    
                                                                }
                                                                ?>
                                                            </h3>
                                                            <div class="timeline-body">
                                                                <?=$resultPA["content"]?>
                                                            </div>
                                                            <div class="timeline-footer" style="display: flex;">
                                                                <a href="controller/comments_controller.php?islem=lastconfirm&id=<?=$resultPA["id"]?>"
                                                                    class="btn bg-gradient-success btn-sm">Onayla
                                                                </a>

                                                                <?php
                                                                
                                                                if ($_SESSION["userdata"]["2"] == 1) { ?>

                                                                <form class="ml-1" action="controller/comments_controller.php"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Silmek istediğine emin misin?')">

                                                                    <input type="hidden" name="id"
                                                                        value="<?= $resultPA['id'] ?>">

                                                                    <input type="submit" name="islem" value="Sil"
                                                                        class="btn btn-sm btn-danger">
                                                                </form>

                                                                <?php } ?>


                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    } 
                                                    ?>
                                                    <div>
                                                        <i class="far fa-clock bg-gray"></i>
                                                    </div>

                                                </div>

                                                <?php
                                                } else { 
                                                    ?>

                                                <div class="callout" style="border-left: 0px">
                                                    <h4 style="text-align: center">Herhangi bir veri bulunamadı
                                                    </h4>
                                                </div>

                                                <?php
                                                }
                                                ?>

                                            </div>

                                            <div class="tab-pane" id="tab_2">
                                                
                                            </div>


                                            <div class="tab-pane" id="tab_3">
                                                <?php 
                                                $blogSql = $config -> prepare("SELECT DISTINCT c.blogID, b.blog_title, b.blog_image,
                                                (SELECT COUNT(*) FROM comments WHERE blogID = b.blog_id) AS comment_count
                                                FROM comments c
                                                INNER JOIN blog b ON c.blogID = b.blog_id");
                                                $blogSql -> execute();
                                                $blogRows = $blogSql -> get_result();
                                                ?>

                                                <?php

                                                if (mysqli_num_rows($blogRows) != 0) { ?>
                                                <div class="row row-cols-md-3">
                                                    <?php
                                                    while ($blogResult = mysqli_fetch_assoc($blogRows)) { ?>

                                                    <div class="col-md-3">
                                                        <div class="card card-widget">
                                                            <div class="card-header">
                                                                <div class="user-block">
                                                                    <span class="username" style="margin-left: 0px;"><a
                                                                            href="blog_comments.php?id=<?=$blogResult["blogID"]?>"><?=$blogResult["blog_title"]?></a></span>
                                                                    <span class="description"
                                                                        style="margin-left: 0px;"><?=$blogResult["comment_count"]?>
                                                                        ADET YORUM</span>
                                                                </div>
                                                                <div class="card-tools">
                                                                    <button type="button" class="btn btn-tool"
                                                                        data-card-widget="collapse">
                                                                        <i class="fas fa-minus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="card-body"
                                                                style="display: block; text-align: center">
                                                                <a
                                                                    href="blog_comments.php?id=<?=$blogResult["blogID"]?>">
                                                                    <img class="img-fluid pad"
                                                                        src="pictures/<?=$blogResult["blog_image"]?>"
                                                                        style="aspect-ratio: 1/1; object-fit: cover;">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php   
                                                    
                                                }
                                                
                                                }  else { 
                                                ?>

                                                    <div class="callout" style="border-left: 0px">
                                                        <h4 style="text-align: center">Herhangi bir veri bulunamadı
                                                        </h4>
                                                    </div>

                                                    <?php
                                                }
                                                ?>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

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

</body>

</html>