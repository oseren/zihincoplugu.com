<?php include("include/config.php"); ?>
<?php include("func.php"); ?>
<?php

ob_start();
session_start();

if (isset($_SESSION['userdata'])) {
   header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Admin Paneli Giriş • <?=$dataname["websitename"]?></title>
    <link rel="shortcut icon" href="../<?=$dataname["favicon"]?>">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b><?=$dataname["websitename"]?></b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Oturumunuzu başlatmak için giriş yapın</p>

                <form action="" method="post">

                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" name="login_btn" class="btn btn-primary btn-block">Giriş Yap</button>
                        </div>
                    </div>
                </form>

            </div>

            <?php
			        if (isset($_SESSION['error'])) {
			 	        $error = $_SESSION['error']; 
			 	        echo "<p class='bg-danger p-2 text-white text-center'>".$error."</p>";
			 	        unset($_SESSION['error']);
			        }
			      ?>
        </div>
    </div>

</body>

</html>

<?php 
 
if (isset($_POST['login_btn'])) {

	$email = mysqli_real_escape_string($config,$_POST['email']);

	$password = mysqli_real_escape_string($config,sha1($_POST['password']));

    $sql = $config -> prepare("SELECT * FROM user WHERE email=? AND password=?");
    $sql -> bind_param("ss",$email,$password);
    $sql -> execute();

    $result = $sql->get_result();

    $data = mysqli_num_rows($result);

	if ($data) {
		$result = mysqli_fetch_assoc($result);
		$userdata = array($result['user_id'],$result['username'],$result['role'],$result['email']);
		$_SESSION['userdata'] = $userdata;
		header("location: index.php");
	} else { 
		$_SESSION['error']="Invalid email/password";
		header("location: login.php");
	}
}
ob_end_flush();
?>