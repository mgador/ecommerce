<?php
require_once('Config.php');

class Product extends Config {

    public function add_product() {

        if(isset($_POST['add_product'])) {
            $category_id = $this->validateInput($_POST['category_id']);
            $item_name = $this->validateInput($_POST['item_name']);
            $description = $this->validateInput($_POST['description']);
            $price = $this->validateInput($_POST['price']);
            $stock_quantity = $this->validateInput($_POST['quantity']);
            $added_by = $this->validateInput($_POST['added_by']);

            $connection = $this->openConnection();
            $stmt = $connection->prepare("INSERT INTO product_tbl (category_id,tem_name, description, price, quantity, added_by) VALUES(?,?,?,?,?,?)");
            $stmt->execute([$category_id,$item_name, $description, $price, $stock_quantity, $added_by]);
            $result = $stmt->rowCount();

            if($result > 0) {
                echo "Product Added Successfully";
            } else {
                echo "Product Added Failed";
            }
        }
        
    }

    private function validateInput($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
}
?>

