<?php include('partials/__header.php'); ?>

<?php $products = $product->view_products($_GET['id']); ?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Product Image</th>
            <th>Item Name</th>
            <th>Price</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 0;
        foreach($products as $product) : ?>
            <tr>
                <td><?= ++$count ?></td>
                <td><img src="assets/images/products/<?php echo $product['item_image']; ?>" alt="item_image" height="80px" width="80px"></td>
                <td><?= $product['item_name']; ?></td>
                <td><?= $product['price']; ?></td>
                <td><?= $product['quantity']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="home.php">Back</a>

<?php include('partials/__footer.php'); ?>
