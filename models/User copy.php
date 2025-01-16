<?php
namespace Models;
use Config\Database;
use Models\AbstractUser;
//i made pdo globale
use PDO;
class User extends AbstractUser {

    public function getPdo() {
        return $this->pdo;
    }
    
    public function register($username, $email, $password, $userType) {
        if (empty($username) || empty($email) || empty($password) || empty($userType)) {
            throw new \Exception("All fields are required.");
        }

        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            throw new \Exception("Email already exists.");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO users (username, email, password_hash, role) VALUES (:username, :email, :password_hash, :role)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $hashedPassword);
        $stmt->bindParam(':role', $userType);


        if ($stmt->execute()) {
            return true; 
        } else {
            throw new \Exception("Database insertion failed."); 
        }
    }

    public function login($email, $password) {
        if (empty($email) || empty($password)) {
            throw new \Exception("Email and password are required.");
        }

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        echo trim($user['password_hash']);
        // var_dump($user);
        if (password_verify($password, trim($user['password_hash']))) {
            echo "check!";
            return $user;
        } else {
            throw new \Exception("Invalid email or password.");
        }
    }



    public static function getUserRole($user_id) {
        $pdo = Database::makeconnection();
        $stmt = $pdo->prepare("SELECT role FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch(pdo::FETCH_ASSOC);

        if ($user) {
            return $user['role'];
        } else {
            return "User not found or not logged in.";
        }
    }

    public function findByUsername($username) {
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail($email){
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        
        
        $stmt = $this->pdo->prepare($query); 
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? $user : null;
    }

    
    
}