<?php
class Config {

    private $server = "mysql:host=localhost;dbname=";
    private $user = "root";
    private $password = "";
    private $options = array(
        PDO::ATTR_ERRMODE => PDO::ATTR_ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );

    public function openConnection() {
        try {
            $this->con = new PDO($this->server, $this->user, $this->password, $this->options);
            return $this->con;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function closeConnection() {
        $this->con = null;
    }
    
}

?>