<?php include "admin/include/config.php"; ?>
<?php include "admin/func.php"; ?>

<?php
$keyword = $_GET['keyword'];

$clean_keyword = url_slug($keyword); // Türkçe karakterleri uygun hale getir ve boşlukları "-" ile değiştir

if (empty($keyword)) {
	header("location: index.php");
}

// pagination
if (!isset($_GET['page'])) {
	$page=1;
} else {
	$page=$_GET['page'];
}
$limit=5;
$offset=($page-1)*$limit;
// -------------------

$sql1 = $config -> prepare("SELECT * FROM blog LEFT JOIN categories ON blog.category=categories.cat_id LEFT JOIN user ON blog.author_id=user.user_id WHERE (blog_title like '%$keyword%' or blog_body like '%$keyword%') AND active=1 ORDER BY blog.publish_date DESC limit $offset,$limit");
$sql1 -> execute();
$rows = $sql1 -> get_result();
$count = $rows->num_rows;
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="og:type" content="website" />
    <meta name="og:title" content="<?=$dataname["websitename"]?>" />
    <meta name="og:image" content="https://localhost/story/<?=$dataname["favicon"]?>" />
    
    <title><?=$keyword?> • <?=$dataname["websitename"]?></title>
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

    <!-- Header area start -->
    <?php include("include/header.php"); ?>

    <div class="section-latest">
        <div class="container">
            <div class="row gutter-v1 align-items-stretch mb-5">
                <div class="col-12">
                    <h2 class="section-title">İÇİN ARAMA SONUCU: <span class="text-primary"><?= $keyword ?></span></h2>
                </div>
                <div class="col-md-9 pr-md-5">
                    <div class="row">

                        <?php if ($count) {
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
                        } } else { ?>
                        <img src="admin/pictures/search_not_found.jpg" alt="Image" class="img-fluid"
                            style="border-radius: 10px; aspect-ratio: 1 / 1; object-fit: cover;">
                        <?php } ?>

                        <!-- Pagination begin -->
                        <?php 

                        $sql2 = $config->prepare("SELECT * FROM blog WHERE (blog_title like '%$keyword%' or blog_body like '%$keyword%') AND active=1");
                        $sql2->execute();
                        $pagination = $sql2->get_result();

                        $total_post = mysqli_num_rows($pagination);

                        $pages = ceil($total_post / $limit);
                        if ($total_post > $limit) {
                        ?>

                        <div class="pag">
                            <div class="pag p1">
                                <ul class="pagination pt-2 pb-5" style="padding-left: 15px;">

                                    <?php

                                    $start = max($page - 2, 1);
                                    $end = min($page + 2, $pages);

                                    // "1 ..." kısmı
                                    if ($start > 1) {
                                        echo '<a class="page-item" href="search/'.urlencode($keyword).'?page=1">1</a>';
                                        if ($start > 2) {
                                            echo '<a class="page-item">...</a>';
                                        }
                                    }

                                    // Sayfa numaralarını göster
                                    for ($i = $start; $i <= $end; $i++) {
                                        echo '<a class="page-item ' . ($i == $page ? "is-active" : "") . '" href="search/'. urlencode($keyword) . '?page=' . $i . '">' . $i . '</a>';
                                    }

                                    // "... (son sayfa sayısı)" kısmı
                                    if ($end < $pages) {
                                        if ($end < $pages - 1) {
                                            echo '<a class="page-item">...</a>';
                                        }
                                        echo '<a class="page-item" href="search/'. urlencode($keyword) . '?page=' . $pages . '">' . $pages . '</a>';
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
