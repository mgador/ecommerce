<?php
require_once('Config.php');

class Product extends Config {

    public function add_items() {

        if(isset($_POST['add_item'])) {
            $category = $_POST['category'];
            $item_name = $_POST['item_name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $stock_quantity = $_POST['quantity'];
            $added_by = $_POST['added_by'];

            $connection = $this->openConnection();
            $connection->beginTransaction();

            // Insert category
            $stmt1 = $connection->prepare("INSERT INTO category_tbl (name) VALUES(?)");
            $stmt1->execute([$category]);
            $category_success = $stmt1->rowCount();

            // Insert product
            $stmt2 = $connection->prepare("INSERT INTO product_tbl (item_name, description, price, quantity, added_by) VALUES(?,?,?,?,?)");
            $stmt2->execute([$item_name, $description, $price, $stock_quantity, $added_by]);
            $product_success = $stmt2->rowCount();

            if ($category_success && $product_success) {
                $connection->commit();
                echo "Item added successfully";
            } else {
                $connection->rollBack();
                echo "Item addition failed";
            }
        }
        
    }
}
?>

