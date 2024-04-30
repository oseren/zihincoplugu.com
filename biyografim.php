<?php include "admin/include/config.php"; ?>
<?php include "admin/func.php"; ?>

<?php 

$sql1 = $config -> prepare("SELECT biography,biographyimage FROM main");
$sql1 -> execute();
$row1 = $sql1 -> get_result();
$post = $row1 -> fetch_assoc();

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

    <title>Biyografim • <?=$dataname["websitename"]?></title>
    <link rel="shortcut icon" href="<?=$dataname["favicon"]?>">

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

    <div class="site-hero py-5 bg-light mb-5">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-12 text-center">
                    <h1 class="text-black mb-0">Biyografim</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <img src="admin/pictures/<?=$post["biographyimage"] ?>" alt="image" class="img-fluid rounded">
                </div>

                <div class="col-lg-8 pl-lg-5">
                
                    <?=$post["biography"] ?>
                </div>
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