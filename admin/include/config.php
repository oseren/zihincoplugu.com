<?php
// $config=mysqli_connect("localhost","root","","blog_web") or die("DB Not Connected");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog_web";

    $config = new mysqli($servername,$username,$password,$dbname) or die("DB Not Connected");
?>