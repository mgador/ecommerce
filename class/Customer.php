<?php require_once('Config.php');

class Customer extends Config {

    public function customer_registration() {
        if(isset($_POST['register'])) {
            // Validate inputs
            $fname = $this->validateInput($_POST['fname']);
            $lname = $this->validateInput($_POST['lname']);
            $username = $this->validateInput($_POST['username']);
            $email = $this->validateInput($_POST['email']);
            $password = $this->validateInput($_POST['password']);
            $password2 = $this->validateInput($_POST['password2']);

            // Check if passwords match
            if($password !== $password2) {
                echo "Passwords do not match.";
                return;
            }

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the data into the database using prepared statements
            $connection = $this->openConnection();
            $stmt = $connection->prepare("INSERT INTO customer_tbl (fname,lname,username,email,password) VALUES(?,?,?,?,?)");
            $stmt->execute([$fname,$lname,$username,$email,$hashedPassword]);
            $result = $stmt->rowCount();

            if($result > 0) {
                echo "Registration Successful";
            } else {
                echo "Registration Failed";
            }
        }
    }

    public function customer_login() {

        
    }

    // Function to validate input (prevent SQL injection)
    private function validateInput($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
}
?>
