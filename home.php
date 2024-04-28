<?php include('partials/__header.php'); ?>
<?php include('middleware/userAuth.php'); ?>

<?php $available_products =  $product->view_available_products();?>

<a href="">Restaurants</a><br><br><br>
<!-- Settings -->
<a href="logout.php">Logout</a>
<a href="seller_register.php?id=<?= $_SESSION['userdata']['id'] ?>">Start Selling</a>
<a href="add_product.php?id=<?= $_SESSION['userdata']['id'] ?>">Add Product</a>
<a href="manage_product.php?id=<?= $_SESSION['userdata']['id'] ?>">Manage Product</a>
<a href="my_cart.php?id=<?= $_SESSION['userdata']['id'] ?>">My Cart</a>

<h1>Available Products</h1>
<?php foreach($available_products as $available_product) : ?>
    <ul>
        <li>
            <a href="product_details.php?product_id=<?= $available_product['product_id'] ?>"><img src="assets/images/products/<?= $available_product['item_image'] ?>" alt="Product Image" height="100" width="100"></a><br>   
            <label><?= $available_product['item_name'] ?></label>
            <p><?= $available_product['description'] ?></p>
            <p><?= number_format($available_product['price'],2) ?> ₱</p>
        </li>
    </ul>
<?php endforeach; ?>


<?php include('partials/__footer.php'); ?>