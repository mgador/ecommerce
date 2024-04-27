<?php include('partials/__header.php'); ?>

<?php $customer->login(); ?>

<?php
if(isset($_SESSION['status'])) {
    echo $_SESSION['status'];
}
?>

<form action="" method="post">
    <input type="email" name="email" id="email" placeholder="Enter your Email" required>
    <input type="password" name="password" id="password" placeholder="Enter your Password" required>

    <input type="submit" name="login" value="Login">
</form>

<?php include('partials/__footer.php'); ?>