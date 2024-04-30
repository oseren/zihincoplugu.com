<?php $page=basename($_SERVER['PHP_SELF'],".php"); ?>

<?php 

$sqlcount = $config -> prepare("SELECT 
COUNT(DISTINCT blog.blog_id) AS blog_count,
COUNT(DISTINCT user.user_id) AS user_count,
COUNT(DISTINCT categories.cat_id) AS category_count,
(SELECT COUNT(*) FROM comments) AS total_comments
FROM 
blog 
LEFT JOIN user ON 1=1
LEFT JOIN categories ON 1=1");
$sqlcount -> execute();
$rowcount = $sqlcount -> get_result();
$resultcount = $rowcount -> fetch_assoc();

?>

<a href="index.php" class="brand-link">
    <img src="../<?= $dataname["favicon"] ?>" alt="logo" class="brand-image img-circle elevation-3"
        style="opacity: .8">
    <span class="brand-text font-weight-light"><?= $dataname["websitename"] ?></span>
</a>

<div class="sidebar">

    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
                <a href="blogs.php" class="nav-link <?= ($page=="blogs")? 'active':''; ?>">
                    <i class="nav-icon fas fa-feather"></i>
                    <p>
                        Bloglar
                        <span class="right badge badge-danger"><?=$resultcount["blog_count"]?></span>
                    </p>
                </a>
            </li>
            <?php 

            if ($_SESSION["userdata"]["2"] == 1) { ?>

            <li class="nav-item">
                <a href="category.php" class="nav-link <?= ($page=="category")? 'active':''; ?>">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                        Kategoriler
                        <span class="right badge badge-danger"><?=$resultcount["category_count"]?></span>
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="users.php" class="nav-link <?= ($page=="users")? 'active':''; ?>">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Kullanıcılar
                        <span class="right badge badge-danger"><?=$resultcount["user_count"]?></span>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="comments.php" class="nav-link <?= ($page=="comments")? 'active':''; ?>">
                    <i class="nav-icon fas fa-comments"></i>
                    <p>
                        Yorumlar
                        <span class="right badge badge-danger"><?=$resultcount["total_comments"]?></span>
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="biography.php" class="nav-link <?= ($page=="biography")? 'active':''; ?>">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                        Biyografim
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="settings.php" class="nav-link <?= ($page=="settings")? 'active':''; ?>">
                    <i class="nav-icon fas fa-cog"></i>
                    
                    <p>
                        Genel Ayarlar
                    </p>
                </a>
            </li>

            <?php } ?>
        </ul>
    </nav>
</div>