<?php include "admin/include/config.php"; ?>

<?php
$sql1 = $config -> prepare("SELECT c.*, COUNT(b.blog_id) as blog_count 
FROM categories c
LEFT JOIN blog b ON c.cat_id = b.category AND b.active = 1
GROUP BY c.cat_id, c.cat_name");
$sql1 -> execute();
$query = $sql1 -> get_result();

$sql2 = $config -> prepare("SELECT biography,biographyname,biographyimage FROM main");
$sql2 -> execute();
$row2 = $sql2 -> get_result();
$result = $row2 -> fetch_assoc();

?>

<div class="mb-4">
    <div class="bio text-center">
        <img src="admin/pictures/<?= $result['biographyimage'] ?>" alt="Image Placeholder" class="img-fluid mb-3">
        <div class="bio-body">
            <h2><?= $result['biographyname'] ?></h2>
            <p class="mb-4">
                <?= strip_tags(substr($result['biography'], 0,200))."..." ?>
            </p>

            <a href="biyografim" class="btn btn-primary btn-sm ">Biyografimi oku</a>

        </div>
    </div>
</div>
<!-- <div class="floating-block sticky-top text-center">
    <h2 class="mb-3 text-black">Kategoriler</h2>
    <div class="categories">
        <ul class="list-unstyled">
            <?php while ($row = mysqli_fetch_assoc($query)) { ?>
            <?php if ( $row['blog_count'] > 0) { ?>

            <li>
                <a href="<?= url_slug($row['cat_name']) ?>">
                    <?= $row['cat_name'] ?>
                    <span>(<?= $row['blog_count'] ?>)</span>
                </a>
            </li>

            <?php } ?>
            <?php } ?>
        </ul>
    </div>
</div> -->

<style>
.categories li,
.sidelink li {
    position: relative;
    margin-bottom: 5px;
    padding-bottom: 5px;
    border-bottom: 1px dotted gray("300");
    list-style: none;
}

.bio img {
    max-width: 175px;
    border-radius: 50%;
}

.bio .bio-body h2,
.bio .bio-body .h2 {
    color: #000;
    font-size: 20px;
}
</style>