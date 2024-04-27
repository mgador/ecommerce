<?php 
require_once('Config.php');

class Seller extends Config {

    public function seller_register() {

        if(isset($_POST['register'])) {
            // Validate and sanitize input data
            $user_id = $this->validateInput($_POST['user_id']);
            $username = $this->validateInput($_POST['username']);
            $email = $this->validateInput($_POST['email']);
            $company_name = $this->validateInput($_POST['company_name']);
            $contact_name = $this->validateInput($_POST['contact_name']);
            $address = $this->validateInput($_POST['address']);
            $phone_number = $this->validateInput($_POST['phone_number']);

            // Proceed with the database operation
            $connection = $this->openConnection();
            $stmt = $connection->prepare("INSERT INTO seller_tbl (user_id,username,email,company_name,contact_name,address,phone_number) VALUES(?,?,?,?,?,?,?)");
            $stmt->execute([$user_id,$username,$email,$company_name,$contact_name,$address,$phone_number]);
            $result = $stmt->rowCount();

            if($result > 0) {
                echo "Seller Registration Successful";
            } else {
                echo "Seller Registration Failed";
            }
        }
    }

    public function view_categories() {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM category_tbl");
        $stmt->execute();
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


