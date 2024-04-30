<?php include("include/config.php"); ?>
<?php include("session.php"); ?>
<?php include("func.php"); ?>
<?php include("../include/commentsFunc.php"); ?>
<?php checkSession(); ?>

<?php 
$blogID=$_GET['id'];
if (empty($blogID)) {
	header("location: blogs.php");
}

if (isset($_SESSION['userdata'])) {
	$author_id=$_SESSION['userdata']['0'];
    $username=$_SESSION['userdata'][1];


}
$sql2 = $config -> prepare("SELECT blog_title FROM blog WHERE blog_id=?");
$sql2 -> bind_param("s",$blogID);
$sql2 -> execute();
$row2 = $sql2 -> get_result();
$result = $row2 -> fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Blog Yorumları • <?=$dataname["websitename"]?></title>
    <link rel="shortcut icon" href="../<?=$dataname["favicon"]?>">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <script src="dist/js/reply_scripts.js"></script>
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
                                <h3 class="card-title"><?=$result["blog_title"]?> Adlı Blog İçin Yorumlar</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <ul class="comment-list">
                                    <?php 

                                        $commentList = getCommentsWithArrayForAdmin($blogID);
                                        $comList = commentsTree($commentList);

                                        printCommentsForAdmin($comList,$blogID);
                                    
                                    ?>
                                </ul>
                            </div>
                        </div>
                </section>
            </div>

            <!-- REQUIRED SCRIPTS -->


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

<style>
.comment-list {
    padding: 0;
    margin: 0;
}

.comment-list .children {
    padding: 12.5px 0 0 30px;
    margin: 0;
    float: left;
    width: 100%;
}

.comment-list li {
    padding: 0;
    margin: 0 0 12.5px 0;
    float: left;
    width: 100%;
    clear: both;
    list-style: none;
}

.comment-list li .vcard {
    width: 80px;
    float: left;
}

.comment-list li .vcard img {
    width: 50px;
    border-radius: 50%;
}

.comment-list li .comment-body {
    float: right;
    width: calc(100% - 80px);
}

.comment-list li .comment-body h3 {
    font-size: 20px;
}

.comment-list li .comment-body .meta {
    text-transform: uppercase;
    font-size: 13px;
    letter-spacing: .1em;
    color: #ccc;
    margin-bottom: 20px;
}

.comment-list li .comment-body .reply {
    padding: 7px 15px;
    background: gray;
    color: #ffffff;
    text-transform: uppercase;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 900;
    letter-spacing: .1rem;
}

.comment-list li .comment-body .reply:hover {
    color: #ffffff;
    background: #8c8c8c;
}
</style>