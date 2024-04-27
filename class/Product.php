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
            $added_by = $_POST['added_by'];

            $image_name = $_FILES['item_image']['name'];
            $image_tmp = $_FILES['item_image']['tmp_name'];
            $image_type = $_FILES['item_image']['type'];

            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

            if(in_array($image_type, $allowed_types)) {

                $seller_id = $this->validateInput($_POST['added_by']);
                $unique_image_name = $seller_id . '_' . $image_name;

                $upload_directory = 'assets/images/products/';
                $target_file = $upload_directory . basename($unique_image_name);
                
                if(move_uploaded_file($image_tmp, $target_file)) {

                    $connection = $this->openConnection();
                    $stmt = $connection->prepare("INSERT INTO product_tbl (category_id, item_name, item_image, description, price, quantity, added_by) VALUES(?,?,?,?,?,?,?)");
                    $stmt->execute([$category_id, $item_name, $unique_image_name, $description, $price, $stock_quantity, $added_by]);
                    $result = $stmt->rowCount();

                    if($result > 0) {
                        echo "Product Added Successfully";
                    } else {
                        echo "Product Added Failed";
                    }
                } else {
                    echo "Failed to upload image.";
                }
            } else {
                echo "Invalid file type. Only JPEG, PNG, and GIF images are allowed.";
            }
        }
        
    }

    public function view_products($id) {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM product_tbl WHERE added_by = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetchAll();
        
        return $data;
    }

    private function validateInput($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
}
?>
