<?php require_once('Config.php');

class Customer extends Config {

    public function customer_registration() {
        if(isset($_POST['register'])) {

            $fname = $this->validateInput($_POST['fname']);
            $lname = $this->validateInput($_POST['lname']);
            $username = $this->validateInput($_POST['username']);
            $email = $this->validateInput($_POST['email']);
            $password = $this->validateInput($_POST['password']);
            $password2 = $this->validateInput($_POST['password2']);

            if($password !== $password2) {
                echo "Passwords do not match.";
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $connection = $this->openConnection();
            $stmt = $connection->prepare("INSERT INTO customer_tbl (firstname,lastname,username,email,password) VALUES(?,?,?,?,?)");
            $stmt->execute([$fname,$lname,$username,$email,$hashedPassword]);
            $result = $stmt->rowCount();

            if($result > 0) {
                echo "Registration Successful";
            } else {
                echo "Registration Failed";
            }
        }
    }

    public function login() {
        if(isset($_POST['login'])) {
            $connection = $this->openConnection();
    
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            $stmt = $connection->prepare("SELECT password FROM customer_tbl WHERE email = ?");
            $stmt->execute([$email]);
            $userPass = $stmt->fetch();
    
            if ($userPass && password_verify($password, $userPass['password'])) {
                $stmt = $connection->prepare("SELECT * FROM customer_tbl WHERE email = ?");
                $stmt->execute([$email]);
                $data = $stmt->fetch();
        
                $user_id = $data['customer_id'];
                $stmt2 = $connection->prepare("SELECT * FROM seller_tbl WHERE user_id = ?");
                $stmt2->execute([$user_id]);
                $data2 = $stmt2->fetch();
                $result2 = $stmt2->rowCount();
    
                if($result2 > 0) {
                    $this->set_session($data2);
                    $this->redirectAfterLogin();
                } else {
                    $this->set_session($data);
                    $this->redirectAfterLogin();
                }
            } else {
                echo "Incorrect Email or Password!";
            }
        }
    }
    
    
    private function redirectAfterLogin() {
        header("Location: home.php");
    }
    

    public function set_session($array){

        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['userdata'] = array (
            "id" => isset($array['seller_id']) ? $array['seller_id'] : $array['customer_id'],
            "email" => $array['email'],
            "username" => $array['username'],
            "fullname" => $array['firstname']." ".$array['lastname']
        );
        return $_SESSION['userdata'];
    }

    public function get_session(){

        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['userdata'])) {
            return $_SESSION['userdata'];
        } else {
            return null;
        }
    }

    public function add_to_cart() {
        if(isset($_POST['add_to_cart'])) {
            
            $customer_id = $_POST['customer_id'];
            $product_id = $_POST['product_id'];
            $item_name = $_POST['item_name'];
            $qty = $_POST['quantity'];
            $price = $_POST['price'];
    
            $total_price = $price * $qty;
    
            $connection = $this->openConnection();
            
            $stmt = $connection->prepare("SELECT * FROM cart_tbl WHERE customer_id = ? AND product_id = ?");
            $stmt->execute([$customer_id, $product_id]);
            $existing_item = $stmt->fetch();
    
            if($existing_item) {

                $new_qty = $existing_item['qty'] + $qty;
                $new_total_price = $existing_item['price'] + $total_price;
    
                $stmt = $connection->prepare("UPDATE cart_tbl SET qty = ?, price = ? WHERE customer_id = ? AND product_id = ?");
                $stmt->execute([$new_qty, $new_total_price, $customer_id, $product_id]);
                $result = $stmt->rowCount();
    
                if(!$result > 0) {
                    echo "Failed to update cart";
                }

            } else {

                $stmt = $connection->prepare("INSERT INTO cart_tbl (customer_id, product_id, item_name, qty, price) VALUES(?, ?, ?, ?, ?)");
                $stmt->execute([$customer_id, $product_id, $item_name, $qty, $total_price]);
                $result = $stmt->rowCount();
    
                if(!$result > 0) {
                    echo "Failed to add to cart";
                }
            }
        }
    }

    public function view_cart($id) {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM cart_tbl WHERE customer_id = ?");
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
