<?php 

$sql1 = $config -> prepare("SELECT blog.*, categories.*, user.username, user.profilephoto FROM blog
                        LEFT JOIN categories ON blog.category = categories.cat_id
                        LEFT JOIN user ON blog.author_id = user.user_id 
                        WHERE active=1
                        ORDER BY blog.publish_date DESC
                        LIMIT 4");

$sql1 -> execute();
$rows = $sql1 -> get_result();

?>

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">SON BLOGLAR</h2>
            </div>

            <?php while($result = mysqli_fetch_assoc($rows)) { ?>

            <div class="col-md-6 col-lg-3">
                <div class="post-entry">
                    <div class="media">
                        <a href="<?= url_slug($result['cat_name']) ?>/<?= url_slug($result['blog_title']) ?>.<?= $result['blog_id'] ?>">
                            <?php $img=$result['blog_image'] ?>
                            <img src="admin/pictures/<?= $img ?>" alt="Image" class="img-fluid" style="border-radius: 10px; aspect-ratio: 1 / 1; object-fit: cover;">

                        </a>
                    </div>
                    <div class="text">
                        <h2>
                            <a href="<?= url_slug($result['cat_name']) ?>/<?= url_slug($result['blog_title']) ?>.<?= $result['blog_id'] ?>">
                                <?= ucfirst($result['blog_title']) ?>
                            </a>
                        </h2>
                        <div class="meta">
                            <?php $date = $result['publish_date'] ?>
                            <?= month_to_turkish(date('d M Y',strtotime($date))) ?>
                            <span>&bullet;</span>
                            <span>
                                <a href="<?= url_slug($result['cat_name']) ?>">
                                    <?= $result['cat_name'] ?>
                                </a>
                            </span>
                        </div>
                        <p> <?= strip_tags(substr($result['blog_body'], 0,120))."..." ?> </p>

                    </div>
                    <div class="author d-flex align-items-center">
                        <div class="img mr-3">
                            <a href="<?= url_slug($result['cat_name']) ?>/<?= url_slug($result['blog_title']) ?>.<?= $result['blog_id'] ?>"><img src="admin/profiles/<?= $result['profilephoto'] ?>" alt="Image" class="img-fluid"></a>
                        </div>
                        <div class="text">
                            <h3><a href="<?= url_slug($result['cat_name']) ?>/<?= url_slug($result['blog_title']) ?>.<?= $result['blog_id'] ?>"><?= $result['username'] ?></a></h3>
                        </div>
                    </div>
                </div>
            </div>


            <?php } ?>

        </div>
    </div>
</div>