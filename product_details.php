<?php include('partials/__header.php'); ?>
<?php include('middleware/userAuth.php'); ?>

<?php $product_details = $product->view_product_details($_GET['product_id']); ?>
<?php $customer->add_to_cart(); ?>
<div>
    <img src="assets/images/products/<?= $product_details['item_image'] ?>" alt="Product Image" height="250" width="250">
    <h3><?= $product_details['item_name'] ?></h3>
    <p><?= $product_details['description'] ?></p>
    <p id="unit-price"><?= number_format($product_details['price'], 2)?> ₱</p>

    <form action="" method="post">
        <label for="quantity">Qty</label>
        <input type="number" name="quantity" id="quantity" min="1" max="<?= $product_details['quantity'] ?>" value="1" required>

        <input type="hidden" name="customer_id" value="<?= $_SESSION['userdata']['id'] ?>">
        <input type="hidden" name="product_id" value="<?= $product_details['product_id'] ?>">
        <input type="hidden" name="item_name" value="<?= $product_details['item_name'] ?>">
        <input type="hidden" name="price" value="<?= $product_details['price'] ?>">

        <br><br>
        <button type="button" onclick="addToCart()">Add to Cart</button>
        <button type="submit" name="add_to_cart" style="visibility: hidden;"></button>
    </form>
    
</div>


<script>
    function addToCart() {
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Item added to cart",
            showConfirmButton: false,
            timer: 1500
        }).then(($result) => {
            document.querySelector('button[name="add_to_cart"]').click();
        });
    }
</script>

<?php include('partials/__footer.php'); ?>
