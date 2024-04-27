<?php include('partials/__header.php'); ?>

<form action="" method="post">
    
    <label for="Categories">Categories</label>
    <select name="category" id="category">
        <option value="Breakfast">Breakfast</option>
        <option value="Lunch">Lunch</option>
        <option value="Dinner">Dinner</option>
        <option value="Dessert">Dessert</option>
    </select>

    <label for="item_name">Item Name</label>
    <input type="text" name="item_name" id="item_name" placeholder="Enter Item Name" required>

    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30" rows="10" placeholder="Enter Item Description" required></textarea>
    
    <label for="price">Price</label>
    <input type="number" name="price" id="price" placeholder="Enter Item Price" required>

    <label for="quantity">Stock Quantity</label>
    <input type="number" name="quantity" id="quantity" placeholder="Enter Stock Quantity" required>

    <input type="hidden" name="added_by" id="added_by" value="<?php ?>">
    

    <button type="submit" name="add_item">Add Item</button>
    
</form>

<?php include('partials/__footer.php'); ?>