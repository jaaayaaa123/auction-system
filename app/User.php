<?php

require_once '../config/database.php'; 

class User {
    private $db;

    public function __construct() {
        
        $this->db = getDbConnection();

       
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

   
    public function register($name, $email, $password) {
        
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

      
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return false; 
        }

        // put new user into the database
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('sss', $name, $email, $hashedPassword);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    
    public function login($email, $password) {
        $sql = "SELECT id, password FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            
            if (password_verify($password, $user['password'])) {
                
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user_id'] = $user['id'];
                return true;
            }
        }
        return false;
    }

   
    public function getId() {
        return $_SESSION['user_id'] ?? null;
    }
}
?>
