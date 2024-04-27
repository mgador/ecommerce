<?php include('partials/__header.php'); ?>

<?php $categories = $seller->view_categories(); ?>
<?php $product->add_product(); ?>

<form action="" method="post" enctype="multipart/form-data">
    
    <label for="Categories">Categories</label>
    <select name="category_id" id="category_id">
        <?php foreach($categories as $category) : ?>
            <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
        <?php endforeach; ?>
    </select>

    <label for="item_name">Item Name</label>
    <input type="text" name="item_name" id="item_name" placeholder="Enter Item Name" required>

    <label for="item_image">Item Image</label>
    <input type="file" name="item_image" id="item_image" accept="image/*" required>

    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30" rows="10" placeholder="Enter Item Description" required></textarea>
    
    <label for="price">Price</label>
    <input type="number" name="price" id="price" placeholder="Enter Item Price" required>

    <label for="quantity">Stock Quantity</label>
    <input type="number" name="quantity" id="quantity" placeholder="Enter Stock Quantity" required>

    <!-- Set the value for the hidden field -->
    <input type="hidden" name="added_by" id="added_by" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">

    <button type="submit" name="add_product">Add Product</button>
    
</form>

<a href="home.php">Back</a>

<?php include('partials/__footer.php'); ?>
