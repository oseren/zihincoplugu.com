<?php
session_start();

function checkSession() {
    if (!isset($_SESSION['userdata'])) {
        header("location: login.php");
        exit();
    }
}

?>
