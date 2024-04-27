<?php include('partials/__header.php'); ?>
<?php include('middleware/userAuth.php'); ?>

<a href="logout.php">Logout</a>
<a href="seller_register.php?id=<?= $_SESSION['userdata']['id'] ?>">Start Selling</a>
<a href="add_product.php?id=<?= $_SESSION['userdata']['id'] ?>">Add Product</a>

<?php include('partials/__footer.php'); ?>