<?php 

if(!isset($_SESSION['userdata'])) {
    $_SESSION['status'] = "Login First!";
    header("Location: login.php");
}
?>