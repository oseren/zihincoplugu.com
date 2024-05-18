<?php
include "../admin/include/config.php"; 
include "../admin/func.php"; 

$randomBlogURLS = array();
$sqlRandomBlog = $config->prepare("SELECT blog_id, blog_title, cat_name FROM blog LEFT JOIN categories ON blog.category=categories.cat_id WHERE active=1");
$sqlRandomBlog->execute();
$rowRandomBlog = $sqlRandomBlog->get_result();

while ($datam = mysqli_fetch_assoc($rowRandomBlog)) {
    $var = "http://".$_SERVER['SERVER_NAME']."/story/".url_slug($datam['cat_name'])."/".url_slug($datam['blog_title']).".".$datam["blog_id"];
    array_push($randomBlogURLS, $var);
}

echo json_encode($randomBlogURLS);
?>