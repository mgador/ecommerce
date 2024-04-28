<?php include('partials/__header.php'); ?>

<?php $products = $product->view_products($_GET['id']); ?>
<?php $product_details = $product->view_single_product(); ?>
<?php $categories = $seller->view_categories(); ?>

<?php $product->update_product(); ?>
<?php $product->delete_product(); ?> 

<?php
    if(isset($_SESSION['delete_status'])) { 
        echo $_SESSION['delete_status'];
        unset($_SESSION['delete_status']);
    } else {
        echo '<script>alert("Session not set");</script>';
    }
?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Product Image</th>
            <th>Item Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Action</th>
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
                <td>
                    <form method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>" required>
                        <button type="submit" name="update" id="updateBtn">Update</button>
                        <button type="button" onclick="deleteProduct(<?php echo $product['product_id']; ?>)">Delete</button>
                        <button type="submit" name="delete_product" style="visibility: hidden;"></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if(isset($_POST['update'])) : ?>
    <div class="product-details">
        <h3>Product Details</h3>

        <form action="" method="post" enctype="multipart/form-data">

        <input type="hidden" name="product_id" value="<?php echo $product_details['product_id']; ?>">

            <label for="Categories">Categories</label>
            <select name="category_id" id="category_id">
                <?php foreach($categories as $category) : ?>
                    <option value="<?php echo $category['category_id']; ?>" <?php echo ($category['category_id'] == $product_details['category_id']) ? 'selected' : ''; ?>><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="item_name">Item Name</label>
            <input type="text" name="item_name" id="item_name" placeholder="Enter Item Name" value="<?php echo isset($product_details['item_name']) ? $product_details['item_name'] : '' ?>" required>

            <label for="item_image">Item Image</label>
            <input type="file" name="item_image" id="item_image" accept="image/*" >

            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="10" placeholder="Enter Item Description" required><?php echo isset($product_details['description']) ? $product_details['description'] : '' ?></textarea>
            
            <label for="price">Price</label>
            <input type="number" name="price" id="price" placeholder="Enter Item Price" value="<?php echo isset($product_details['price']) ? $product_details['price'] : '' ?>" required>

            <label for="quantity">Stock Quantity</label>
            <input type="number" name="quantity" id="quantity" placeholder="Enter Stock Quantity" value="<?php echo isset($product_details['quantity']) ? $product_details['quantity'] : '' ?>" required>

            <input type="hidden" name="added_by" id="added_by" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">

            <button type="submit" name="update_product">Save</button>
            
        </form>
    
    </div>
<?php endif; ?>

<script>
    function deleteProduct(productId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector('input[name="product_id"]').value = productId;
                document.querySelector('button[name="delete_product"]').click();
            }
        });
    }
</script>

<?php include('partials/__footer.php'); ?>
