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
    
    // public function register($username, $email, $password, $userType) {
    //     if (empty($username) || empty($email) || empty($password) || empty($userType)) {
    //         throw new \Exception("All fields are required.");
    //     }

    //     $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = :email");
    //     $stmt->bindParam(':email', $email);
    //     $stmt->execute();
    //     if ($stmt->rowCount() > 0) {
    //         throw new \Exception("Email already exists.");
    //     }

    //     // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    //     $hashedPassword = $password;
        
    //     $query = "INSERT INTO users (username, email, password_hash, role) VALUES (:username, :email, :password_hash, :role)";
    //     $stmt = $this->pdo->prepare($query);
    //     $stmt->bindParam(':username', $username);
    //     $stmt->bindParam(':email', $email);
    //     $stmt->bindParam(':password_hash', $hashedPassword);
    //     $stmt->bindParam(':role', $userType);


    //     if ($stmt->execute()) {
    //         return true; 
    //     } else {
    //         throw new \Exception("Database insertion failed."); 
    //     }
    // }

    // public function login($email, $password) {
    //     // if (empty($email) || empty($password)) {
    //     //     throw new \Exception("email and password are required");
    //     // }
    
    //     $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
    //     $stmt->bindParam(':email', $email);
    //     $stmt->execute();
    //     $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
       
    //     if ($user) {
      
    //         if (password_verify($password, trim($user['password_hash']))) {
    //             return $user;
    //         } else {
    //             throw new \Exception(" invalid email or password");
               
    //         }
    //     } else {
    //         throw new \Exception("email is not exist.");
    //     }
    // }
    
    public function register($username, $email, $password, $userType) {
        if (empty($username) || empty($email) || empty($password) || empty($userType)) {
            throw new \Exception("All fields are required.");
        }

        // Check if email already exists
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            throw new \Exception("Email already exists.");
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // $hashedPassword = hash($password, 256);
        
        // Insert new user into the database
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

    // Method to log in a user
    public function login($email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        if (empty($email) || empty($password)) {
            throw new \Exception("Email and password are required.");
        }

        // Retrieve the user from the database
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
      
        if ( password_verify($password, $user['password_hash'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role']; // Store user role for authorization

            
        } 
        return $user; // Return user data on success
       
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

    public function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
    }

    
}