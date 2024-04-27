<?php include('partials/__header.php'); ?>
<?php include('middleware/userAuth.php'); ?>

<?php $seller->seller_register(); ?>

<form action="" method="post">

    <input type="hidden" name="user_id" id="user_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">

    <label for="username">Username</label>
    <input type="text" name="username" id="username" placeholder="Enter your username" value="<?php echo isset($_SESSION['userdata']['username']) ? $_SESSION['userdata']['username'] : '' ?>" required>

    <label for="email">Email</label>
    <input type="email" name="email" id="email" placeholder="Enter your email" value="<?php echo isset($_SESSION['userdata']['email']) ? $_SESSION['userdata']['email'] : ''; ?>">

    <label for="company_name">Company Name</label>
    <input type="text" name="company_name" id="company_name" placeholder="Enter your Company Name / Shop Name" required>

    <label for="contact_name">Contact Name</label>
    <input type="text" name="contact_name" id="contact_name" placeholder="Enter your Contact Name" require>

    <label for="address">Address</label>
    <input type="text" name="address" id="address" placeholder="Enter your address" require>

    <label for="phone_number">Phone Number</label>
    <input type="number" name="phone_number" id="phone_number" placeholder="Enter your Phone Number" required>

    <button type="submit" name="register">Save</button>
</form>

<a href="home.php">Back</a>

<?php include('partials/__footer.php'); ?>
