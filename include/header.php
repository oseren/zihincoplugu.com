
<?php 

$sql3 = $config -> prepare("SELECT websitename,instagramlink,twitterlink,pinterestlink FROM main");
$sql3 -> execute();
$row3 = $sql3 -> get_result();
$data = $row3 -> fetch_assoc();

?>

<div class="container">
    <!-- navbar start area -->
    <nav class="site-nav">
        <div class="row justify-content-between align-items-center">
            <div class="d-none d-lg-block col-lg-3 top-menu">
                <a href="<?= $data["instagramlink"] ?>" class="d-inline-flex align-items-center"><span class="icon-instagram mr-2"></span></a>
                <a href="<?= $data["twitterlink"] ?>" class="d-inline-flex align-items-center"><span class="icon-twitter mr-2"></span></a>
                <a href="<?= $data["pinterestlink"] ?>" class="d-inline-flex align-items-center"><span class="icon-pinterest mr-2"></span></a>
            </div>
            <div class="col-3 col-md-6 col-lg-6 text-lg-center logo">
                <a href="index.php"><?= $data["websitename"] ?><span class="text-primary">.</span> </a>
            </div>
            <div class="col-9 col-md-6 col-lg-3 text-right top-menu">

                <div class="d-inline-flex align-items-center">
                    <div class="search-wrap">
                        <a class="d-inline-flex align-items-center js-search-toggle"><span
                                class="icon-search2 mr-2"></span><span>Arama</span></a>

                        <form action="search.php" class="d-flex">
                            <input type="search" id="s" class="form-control"
                                placeholder="Kelimeyi girin ve enter'a basın..." name="keyword" autocomplete="off">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>

