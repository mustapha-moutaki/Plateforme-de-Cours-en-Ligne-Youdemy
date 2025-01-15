<?php
namespace Models;
use Config\Database;
use Models\AbstractUser;

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

        if ($user && password_verify($password, $user['password_hash'])) {
            return $user; // Return user data if credentials are correct
        } else {
            throw new \Exception("Invalid email or password.");
        }
    }
}