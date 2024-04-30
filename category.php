<?php include "admin/include/config.php"; ?>
<?php include "admin/func.php"; ?>

<?php
// pagination
if (!isset($_GET['page'])) {
	$page=1;
} else {
	$page=$_GET['page'];
}
$limit=5;
$offset=($page-1)*$limit;

$categoryname = $_GET['id'];

$sqlid = $config->prepare("SELECT cat_id FROM categories WHERE cat_name=?");
$sqlid -> bind_param("s",$categoryname);
$sqlid->execute();
$rowid = $sqlid -> get_result();
$resultid = $rowid -> fetch_assoc();

$cat_id = $resultid["cat_id"];

$sql2 = $config->prepare("SELECT * FROM blog WHERE category=? AND active=1");
$sql2 -> bind_param("s",$cat_id);
$sql2->execute();
$pagination = $sql2->get_result();

$total_post = mysqli_num_rows($pagination);

$pages = ceil($total_post / $limit);

if ($page > $pages) {
    header("Location: 404");
    exit();
}

if (empty($categoryname)) {
	header("location: 404");
} else {

    $blogCountCheck = $config->prepare("SELECT COUNT(*) as count FROM categories WHERE cat_name = ?");
    $blogCountCheck->bind_param("s", $categoryname);
    $blogCountCheck->execute();
    $blogCheckResult = $blogCountCheck->get_result();
    $blogRowCount = $blogCheckResult->fetch_assoc()['count'];

    if ($blogRowCount == 0) {
        
        header("location: 404");

    } else {

        $activeBlogCheck = $config->prepare("SELECT COUNT(*) as active_count FROM blog WHERE category=(SELECT cat_id FROM categories WHERE cat_name=?) AND active=1");
        $activeBlogCheck->bind_param("s", $categoryname);
        $activeBlogCheck->execute();
        $activeBlogResult = $activeBlogCheck->get_result();
        $activeRowCount = $activeBlogResult->fetch_assoc()['active_count'];

        if ($activeRowCount == 0) {
            header("location: 404");
        } else {

            $sql1 = $config -> prepare("SELECT * FROM blog LEFT JOIN categories ON blog.category=categories.cat_id LEFT JOIN user ON blog.author_id=user.user_id WHERE cat_name=? AND active=1 ORDER BY blog.publish_date DESC limit $offset,$limit");
            $sql1 -> bind_param("s",$categoryname);
            $sql1 -> execute();
            $rows = $sql1 -> get_result();

        }

    }

}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="og:type" content="website" />
    <meta name="og:title" content="<?=$dataname["websitename"]?>" />
    <meta name="og:image" content="https://localhost/story<?=$dataname["favicon"]?>" />
    
    <title><?=ucfirst($categoryname)?> Kategorisi • <?=$dataname["websitename"]?></title>
    <link rel="shortcut icon" href="<?=$dataname["favicon"]?>">

    <base href="http://localhost/story/" />

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>


    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close">
                <span class="icofont-close js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>


    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close">
                <span class="icofont-close js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>

    <!-- header area start -->
    <?php include("include/header.php"); ?>

    <div class="section-latest">
        <div class="container">
            <div class="row gutter-v1 align-items-stretch mb-5">
                <div class="col-12">
                    <h2 class="section-title"><?=$categoryname?> Kategorisi</h2>
                </div>
                <div class="col-md-9 pr-md-5">
                    <div class="row">
                        <?php if ($rows) {
                        while($result = mysqli_fetch_assoc($rows)) { ?>
                        <div class="col-12">
                            <div class="post-entry horizontal d-md-flex">
                                <div class="media">
                                    <a href="<?= url_slug($result['cat_name']) ?>/<?= url_slug($result['blog_title']) ?>.<?= $result['blog_id'] ?>">
                                        <?php $img=$result['blog_image'] ?>
                                        <img src="admin/pictures/<?= $img ?>" alt="Image" class="img-fluid"
                                            style="border-radius: 10px; aspect-ratio: 1 / 1; object-fit: cover;">
                                    </a>
                                </div>
                                <div class="text">
                                    <div class="meta">
                                        <span>
                                            <?php $date=$result['publish_date'] ?>
                                            <?= month_to_turkish(date('d M Y',strtotime($date))) ?>
                                        </span>
                                        <span>&bullet;</span>
                                        <span>
                                            <a href="<?= url_slug($result['cat_name']) ?>">
                                                <!-- class="text-primary" -->
                                                <?= $result['cat_name'] ?>
                                            </a>
                                        </span>
                                    </div>
                                    <h2>
                                        <a href="<?= url_slug($result['cat_name']) ?>/<?= url_slug($result['blog_title']) ?>.<?= $result['blog_id'] ?>" id="title">
                                            <?= ucfirst($result['blog_title']) ?>
                                        </a>

                                    </h2>
                                    <p>
                                        <a href="<?= url_slug($result['cat_name']) ?>/<?= url_slug($result['blog_title']) ?>.<?= $result['blog_id'] ?>" id="body">
                                            <?= strip_tags(substr($result['blog_body'], 0,280))."..." ?>
                                        </a>
                                        <!-- <span>
                                          <br>
                                            <a href="single_post.php?id=<?= $result['blog_id'] ?>"
                                                class="btn btn-sm btn-outline-primary">Continue Reading
                                            </a>
                                          </span> -->
                                    </p>

                                </div>
                            </div>
                        </div>
                        <?php
                        }
                      } ?>

                        <?php 

                        if ($total_post > $limit) {
                        ?>

                        <div class="pag">
                            <div class="pag p1">
                                <ul class="pagination pt-2 pb-5" style="padding-left: 15px;">

                                    <?php

                                    $start = max($page - 2, 1);
                                    $end = min($page + 2, $pages);

                                    if ($start > 1) {
                                        echo '<a class="page-item" href="'. $categoryname . '&page=">1</a>';
                                        if ($start > 2) {
                                            echo '<a class="page-item">...</a>';
                                        }
                                    }

                                    for ($i = $start; $i <= $end; $i++) {
                                        echo '<a class="page-item ' . ($i == $page ? "is-active" : "") . '" href="'. $categoryname . '&page=' . $i . '">' . $i . '</a>';
                                    }

                                    if ($end < $pages) {
                                        if ($end < $pages - 1) {
                                            echo '<a class="page-item">...</a>';
                                        }
                                        echo '<a class="page-item" href="'. $categoryname . '&page=' . $pages . '">' . $pages . '</a>';
                                    }
                                    ?>

                                </ul>
                            </div>
                        </div>

                        <?php } ?>

                    </div>
                </div>

                <!-- Sidebar area start -->
                <div class="col-md-3">
                    <?php include("include/sidebar.php"); ?>
                </div>
        </div>
                <!-- Recent post area start -->
                <?php include("include/recent_blog.php"); ?>

    </div>

    <div id="overlayer"></div>
    <div class="loader">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>

    <!-- Footer area start -->
    <?php include("include/footer.php"); ?>
</body>

</html>


<style>
.pag {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    font-family: 'Open Sans', sans-serif;
    color: #222;
}

/* GENERAL STYLES */

.pag ul {
    margin: 0;
    padding: 0;
    list-style-type: none;
}

.pag a {
    display: inline-block;
    padding: 10px 18px;
    color: #222;
}

/* ONE */

.pag .p1 a {
    width: 40px;
    height: 40px;
    line-height: 40px;
    padding: 0;
    text-align: center;
}

.pag .p1 a.is-active {
    background-color: #a4c639;
    border-radius: 100%;
    color: #fff;
}
</style>