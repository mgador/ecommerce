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

    public function login() {
        if(isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            $connection = $this->openConnection();
    
            $customer_data = $this->checkCredentials($connection, 'customer_tbl', $email, $password);
            if($customer_data) {
                $this->set_session($customer_data);
                $this->redirectAfterLogin();
            } else {
                $seller_data = $this->checkCredentials($connection, 'seller_tbl', $email, $password);
                if($seller_data) {
                    $this->set_session($seller_data);
                    $this->redirectAfterLogin();
                } else {
                    echo "Incorrect email or password";
                }
            }
        }
    }
    
    private function checkCredentials($connection, $table, $email, $password) {
        $stmt = $connection->prepare("SELECT * FROM $table WHERE email = ?");
        $stmt->execute([$email]);
        $user_data = $stmt->fetch();
        if ($user_data && password_verify($password, $user_data['password'])) {
            return $user_data;
        }
        return null;
    }
    
    private function redirectAfterLogin() {
        header("Location: home.php");
        exit; 
    }
    

    public function set_session($array){

        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['userdata'] = array (
            "id" => $array['id'],
            "email" => $array['email'],
            "fullname" => $array['firstname']." ".$array['lastname'],
            "access" => $array['access']
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

    // Function to validate input (prevent SQL injection)
    private function validateInput($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
}
?>
