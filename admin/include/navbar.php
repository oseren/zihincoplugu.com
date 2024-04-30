<?php

$sqlnavbar = $config -> prepare("SELECT profilephoto FROM user WHERE user_id=?");
$sqlnavbar -> bind_param("s",$_SESSION['userdata']['0']);
$sqlnavbar -> execute();
$rownavbar = $sqlnavbar -> get_result();
$resultnavbar = $rownavbar -> fetch_assoc();

?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- User profile -->

        <li class="nav-item dropdown user-menu">
            <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="profiles/<?=$resultnavbar["profilephoto"]?>" class="user-image img-circle elevation-2" alt="User Image" style="aspect-ratio: 2 / 5">
                <span class="d-none d-md-inline">
                    <?php 
                        if (isset($_SESSION['userdata'])) {
                            echo $_SESSION['userdata']['1'];
                        } 
                    ?>
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="profiles/<?=$resultnavbar["profilephoto"]?>" class="img-circle elevation-2" alt="User Image">

                    <p>
                        <?php 
                            if (isset($_SESSION['userdata'])) {
                                echo $_SESSION['userdata']['1'];
                            } 
                        ?>
                    </p>
                    
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="profilephoto.php" class="btn btn-default btn-flat">Profil F. Değiştir</a>
                    
                    <a href="include/logout.php" class="btn btn-default btn-flat float-right">Çıkış Yap</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>