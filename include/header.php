<?php 

$url = $_SERVER['REQUEST_URI'];

$url_parts = explode("/", $url);
$extension = end($url_parts);

$urlname = $url_parts[2];

?>
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
                <a href="<?= $data["instagramlink"] ?>" class="d-inline-flex align-items-center"><span
                        class="icon-instagram mr-2"></span></a>
                <a href="<?= $data["twitterlink"] ?>" class="d-inline-flex align-items-center"><span
                        class="icon-twitter mr-2"></span></a>
                <a href="<?= $data["pinterestlink"] ?>" class="d-inline-flex align-items-center"><span
                        class="icon-pinterest mr-2"></span></a>
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

        <div class="d-none d-lg-block row py-3">


            <div class="col-12 col-sm-12 col-lg-12 site-navigation text-center">
                <ul class="js-clone-nav d-none d-lg-inline-block text-left site-menu" style="padding-left: 0px;">
                    <?php 
            
            $sqlD = $config -> prepare("SELECT c.*, COUNT(b.blog_id) as blog_count 
            FROM categories c
            LEFT JOIN blog b ON c.cat_id = b.category AND b.active = 1
            GROUP BY c.cat_id, c.cat_name");

            $sqlD -> execute();

            $queryD = $sqlD -> get_result();
            ?>

                    <li class="<?= ($urlname=="zihninibosalt")? 'active':''; ?>"><a href="zihninibosalt">Zihnini
                            Boşalt</a></li>

                    <?php while ($row = mysqli_fetch_assoc($queryD)) { ?>
                    <?php if ( $row['blog_count'] > 0) { ?>
                    <li class="<?= ($urlname==url_slug($row['cat_name']))? 'active':''; ?>">

                        <a href="<?= url_slug($row['cat_name']) ?>">

                            <?= $row['cat_name'] ?>

                        </a>

                    </li>



                    <?php } ?>

                    <?php } ?>
                    <li><a onclick="getRandomBlog()">Rastgele Blog</a></li>
                </ul>

            </div>

        </div>
    </nav>
</div>

<script>
async function getRandomBlog() {
    try {
        const response = await fetch('include/get_random_blog.php');
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        const blogs = await response.json();

        if (blogs.length === 0) {
            console.log("Blog listesi boş.");
            return;
        }

        const randomIndex = Math.floor(Math.random() * blogs.length);
        const randomBlog = blogs[randomIndex];

        if (window.location.href != randomBlog) {
            window.location.href = randomBlog;
        }
    } catch (error) {
        console.error('Blog URL\'leri alınamadı:', error);
    }
}
</script>