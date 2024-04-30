<?php include "admin/include/config.php"; ?>
<?php include "admin/func.php"; ?>
<?php include "include/commentsFunc.php"; ?>

<?php
// Get URL
$current_url = $_SERVER['REQUEST_URI'];

$parts = explode("/", $current_url);
$blog_id_with_extension = end($parts);
$blog_id_parts = explode(".", $blog_id_with_extension);
$blog_id = $blog_id_parts[1];

$categoryn = $parts[2];

$id = $blog_id;
// Get URL
?>

<?php
// Views Count
if (!isset($_COOKIE["views"])) {
    $blog_ids = array();
} else {
    $blog_ids = json_decode($_COOKIE['views'], true);

}

if(isset($id)) {
    if(!in_array($id, $blog_ids)) {
        $blog_ids[] = $id;

        $demo = $config->prepare("UPDATE blog SET views=views+1 WHERE blog_id=?");
        $demo->bind_param("s", $id);
        $demo->execute();
    
    }
    
    setcookie('views', json_encode($blog_ids), time() + (86400 * 30), '/'); // 30 gün boyunca geçerli olan bir çerez
}
// Views Count
?>

<?php
// URL Control
if (empty($id)) {
	header("location: ../404");
} else {
    
    $checkQuery = $config->prepare("SELECT COUNT(*) as count FROM blog WHERE blog_id = ?");
    $checkQuery->bind_param("s", $id);
    $checkQuery->execute();
    $checkResult = $checkQuery->get_result();
    $rowCount = $checkResult->fetch_assoc()['count'];

    if ($rowCount == 0) {

        header("location: ../404");

    } else {

        $sql1 = $config -> prepare("SELECT * FROM blog LEFT JOIN categories ON blog.category=categories.cat_id WHERE blog_id=?");
        $sql1 -> bind_param("s",$id);
        $sql1 -> execute();
        $row1 = $sql1 -> get_result();
        $post = $row1 -> fetch_assoc();

        if (!(reverse_url_slug($categoryn) == url_slug($post["cat_name"])) || !(reverse_url_slug($blog_id_parts[0]) == url_slug($post["blog_title"]))) {
            header("location: ../".url_slug($post["cat_name"])."/".url_slug($post["blog_title"]).".".$post["blog_id"]);
        }
    }
}
// URL Control
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="og:type" content="website" />
    <meta name="og:title" content="<?=ucfirst($post["blog_title"])?>" />
    <meta name="og:image" content="https://localhost/story/admin/pictures/<?=$img ?>" />
    <meta name="og:description" content="<?= strip_tags(substr($post['blog_body'], 0,280))."..." ?>" />

    <title><?=$post["blog_title"]?> • <?=$dataname["websitename"]?></title>
    <link rel="shortcut icon" href="<?=$dataname["favicon"]?>">

    <base href="http://localhost/story/" />

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">

    <script src="admin/plugins/jquery/jquery.min.js"></script>
    <script src="js/comment_scripts.js"></script>
    <script src="js/reply_scripts.js"></script>
    <script src="js/likeSystem_scripts.js"></script>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <!-- Header area start -->
    <?php include("include/header.php"); ?>

    <div class="featured-post single-article">
        <div class="container">
            <?php $img=$post['blog_image'] ?>
            <div class="post-slide single-page"
                style="background-image: url('admin/pictures/<?= $img ?>'); border-radius: 10px;">
                <div class="text-wrap pb-5" style="border-radius: 10px;">
                    <div class="share">
                        <ul class="list-unstyled">
                            <li><a href="<?= $data["instagramlink"] ?>"><span class="icon-instagram"></span></a></li>
                            <li><a href="<?= $data["twitterlink"] ?>"><span class="icon-twitter"></span></a></li>
                            <li><a href="<?= $data["pinterestlink"] ?>"><span class="icon-pinterest"></span></a></li>

                        </ul>
                    </div>
                    <h2 class="text-black"><?= ucfirst($post['blog_title']) ?></h2>
                    <div class="meta">
                        <span>
                            <?php $date = $post['publish_date'] ?>
                            <?= month_to_turkish(date('d M Y',strtotime($date))) ?>
                        </span>
                        <span>&bullet;</span>
                        <span>
                            <a href="<?= url_slug($post['cat_name']) ?>">
                                <?= $post['cat_name'] ?>
                            </a>
                        </span>
                    </div>

                    <?php if ($post['views'] != 0) { ?>
                    <div class="meta">
                        <span>
                            <?= $post['views'] ?> Görüntülenme
                        </span>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>


    <div class="container article">
        <div class="row justify-content-center align-items-stretch">

            <article class="col-lg-8 order-lg-2 px-lg-5">

                <p><?= $post['blog_body'] ?></p>

                <div class="pt-5 categories_tags">
                    <p>Kategori: <a href="<?= url_slug($post['cat_name']) ?>"><?= $post['cat_name'] ?></a></p>
                </div>

                <?php 
                
                $sqlPrevious = $config->prepare("SELECT blog.blog_id, blog.blog_title, categories.cat_name
                                                FROM blog 
                                                LEFT JOIN categories ON blog.category = categories.cat_id
                                                WHERE blog.blog_id < ? AND blog.active=1
                                                ORDER BY blog.blog_id DESC 
                                                LIMIT 1");
                $sqlPrevious->bind_param("s", $id);
                $sqlPrevious->execute();
                $rowPrevious = $sqlPrevious->get_result();
                $previousPost = $rowPrevious->fetch_assoc();

                $sqlNext = $config->prepare("SELECT blog.blog_id, blog.blog_title, categories.cat_name
                                            FROM blog 
                                            LEFT JOIN categories ON blog.category = categories.cat_id
                                            WHERE blog.blog_id > ? AND blog.active=1
                                            ORDER BY blog.blog_id ASC 
                                            LIMIT 1");

                $sqlNext->bind_param("s", $id);
                $sqlNext->execute();
                $rowNext = $sqlNext->get_result();
                $nextPost = $rowNext->fetch_assoc();

                ?>

                <div class="post-single-navigation d-flex align-items-stretch">

                    <?php 
                    if (!empty($previousPost)) { ?>

                    <a href="<?= url_slug($previousPost['cat_name']) ?>/<?= url_slug($previousPost['blog_title']) ?>.<?= $previousPost['blog_id'] ?>"
                        class="mr-auto w-50 pr-4">
                        <span class="d-block">Önceki Blog</span>
                        <?= $previousPost['blog_title'] ?>
                    </a>

                    <?php } 
                    ?>

                    <?php 
                    if (!empty($nextPost)) { ?>

                    <a href="<?= url_slug($nextPost['cat_name']) ?>/<?= url_slug($nextPost['blog_title']) ?>.<?= $nextPost['blog_id'] ?>"
                        class="ml-auto w-50 text-right pl-4">
                        <span class="d-block">Sonraki Blog</span>
                        <?= $nextPost['blog_title'] ?>
                    </a>

                    <?php } 
                    ?>
                </div>

                <?php 
                
                if ($post["commentActive"] != 0) { ?>
                <div class="pt-5">
                    <?php 
                        $countComments = countComments($id)
                        ?>

                    <?php 
                        if ($countComments != 0) {
                    ?>
                    <h3 class="mb-5"><?=$countComments?> Yorum</h3>
                    <ul class="comment-list">
                        <?php 

                        $commentList = getCommentsWithArray($id);
                        $comList = commentsTree($commentList);

                        printComments($comList,$id);
                        ?>
                    </ul>

                    <?php
                        }
                    ?>
                    <div class="comment-form-wrap pt-3">
                        <h3 class="mb-5"><?=$countComments == 0 ? 'İlk Yorumu Bırak' : 'Bir Yorum Bırak' ?></h3>
                        <div class="comment-list-box">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="İsim"
                                        autocomplete="off" required>
                                        <div class="errorName"></div>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" placeholder="Email"
                                        autocomplete="off" required>
                                        <div class="errorEmail"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <textarea name="message" id="message" cols="30" rows="5" class="form-control"
                                    placeholder="Yorum için yazın" autocomplete="off" required></textarea>
                                <div class="errorMessage"></div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" value="<?=$id?>" name="blogID" class="blogID">
                                <input type="submit" name="submit" value="Yorum yaz" class="btn btn-primary btn-md"
                                    onClick="callCrudAction('add',this)">
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }

                ?>


            </article>

            <?php 
            $likes = array();
            if (isset($_COOKIE["likes"])) {
                $likes = json_decode($_COOKIE['likes']);
            }
            ?>

            <div class="col-md-12 col-lg-1 order-lg-1">
                <div class="share sticky-top">
                    <h3 style="">Beğen</h3>
                    <ul class="list-unstyled share-article">
                        <li>

                            <?php 
                            
                            if (!in_array($id, $likes)) { ?>

                            <a class="like" onclick="callLikeAction('like','<?=$id?>')" style="border: 0px">
                                <span class="icon-heart-o h1"></span>
                            </a>

                            <?php
                            } else { ?>

                            <a class="unlike" onclick="callLikeAction('unlike','<?=$id?>')" style="border: 0px">
                                <span class="icon-heart h1"></span>
                            </a>

                            <?php
                            }
                            ?>

                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 mb-5 mb-lg-0 order-lg-3">
                <!-- Footer area start -->
                <?php include("include/sidebar.php"); ?>
            </div>
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