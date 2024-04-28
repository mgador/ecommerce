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

    public function update_product() {
        if(isset($_POST['update_product'])) {
            $product_id = $this->validateInput($_POST['product_id']);
            $category_id = $this->validateInput($_POST['category_id']);
            $item_name = $this->validateInput($_POST['item_name']);
            $description = $this->validateInput($_POST['description']);
            $price = $this->validateInput($_POST['price']);
            $stock_quantity = $this->validateInput($_POST['quantity']);
            $added_by = $_POST['added_by'];
            
            $old_image_filename = ''; 
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT item_image FROM product_tbl WHERE product_id = ?");
            $stmt->execute([$product_id]);
            $old_image_data = $stmt->fetch();
            if($old_image_data) {
                $old_image_filename = $old_image_data['item_image'];
            }
            
            if(isset($_FILES['item_image']['name']) && !empty($_FILES['item_image']['name'])) {
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
                        // If old item image exists, delete it
                        if(!empty($old_image_filename)) {
                            $old_image_path = $upload_directory . $old_image_filename;
                            if(file_exists($old_image_path)) {
                                unlink($old_image_path);
                            }
                        }
                        $image_to_use = $unique_image_name;
                    } else {
                        echo "Failed to upload image.";
                        return;
                    }
                } else {
                    echo "Invalid file type. Only JPEG, PNG, and GIF images are allowed.";
                    return;
                }
            } else {
                $image_to_use = $old_image_filename;
            }

            $connection = $this->openConnection();
            $stmt = $connection->prepare("UPDATE product_tbl SET category_id=?, item_name=?, item_image=?, description=?, price=?, quantity=?, added_by=? WHERE product_id=?");
            $stmt->execute([$category_id, $item_name, $image_to_use, $description, $price, $stock_quantity, $added_by, $product_id]);
            $result = $stmt->rowCount();
    
            if($result > 0) {
                echo "Product Updated Successfully";
            } else {
                echo "Product Update Failed";
            }
        }
    }

    public function delete_product() {
        if(isset($_POST['delete_product'])) {
            $product_id = $this->validateInput($_POST['product_id']);
            
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT item_image FROM product_tbl WHERE product_id = ?");
            $stmt->execute([$product_id]);
            $item_image = $stmt->fetchColumn();
    
            $stmt = $connection->prepare("DELETE FROM product_tbl WHERE product_id = ?");
            $stmt->execute([$product_id]);
            $result = $stmt->rowCount();
    
            if($result > 0) {
                if(!empty($item_image)) {
                    $image_path = 'assets/images/products/' . $item_image;
                    if(file_exists($image_path)) {
                        unlink($image_path); 
                    }
                }
                $_SESSION['delete_status'] = '<div class="alert alert-success alert-dismissible position-fixed top-0 end-0 m-3" style="z-index: 9999;" role="alert">
                                                Product Updated Successfully
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>';
                // Get the current page URL
                $url = $_SERVER['REQUEST_URI'];
                // Redirect back to the current page
                header("Location: $url");
                exit();
            } else {
                echo "Product Deletion Failed";
            }
        }
    }

    public function view_available_products() {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM product_tbl ORDER BY RAND()");
        $stmt->execute();
        $data = $stmt->fetchAll();

        return $data;
    }

    public function view_products($id) {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM product_tbl WHERE added_by = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetchAll();
        
        return $data;
    }

    public function view_product_details($id) {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM product_tbl WHERE product_id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        return $data;
    }

    public function view_single_product() {
        if(isset($_POST['update'])) {

            $product_id = $_POST['product_id'];

            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM product_tbl WHERE product_id = ?");
            $stmt->execute([$product_id]);
            $data = $stmt->fetch();

            return $data;
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
