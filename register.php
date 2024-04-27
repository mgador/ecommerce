<?php include('partials/__header.php'); ?>

<?php $customer->registration(); ?>

<form action="" method="post">
    <input type="text" name="fname" id="fname" placeholder="Enter your First Name" required>
    <input type="text" name="lname" id="lname" placeholder="Enter your Last Name" required>

    <input type="text" name="username" id="username" placeholder="Enter your username" required>
    <input type="email" name="email" id="email" placeholder="Enter your Email" required>
    <input type="password" name="password" id="password" placeholder="Enter your Password" required>
    <input type="password" name="password2" id="password2" placeholder="Retype your Password" required>

    <input type="submit" name="register" value="Register">
</form>

<?php include('partials/__footer.php'); ?>