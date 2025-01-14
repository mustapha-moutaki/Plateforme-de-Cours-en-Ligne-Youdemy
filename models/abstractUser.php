<?php
namespace Models;

abstract class User {
    protected $pdo;
    protected $table = "users";
    
    protected $id;
    protected $name;
    protected $email;
    protected $password;
    protected $role;

    protected $bio;
    protected $status;

    public function __construct($db) {
        $this->pdo = $db;
    }

    // public function create($name, $email, $password, $role): bool {
    //     $query = "INSERT INTO " . $this->table . " SET name=:name, email=:email, password=:password, role=:role, status=:status";
    //     $stmt = $this->pdo->prepare($query);

    //     $params = [
    //         ":name" => htmlspecialchars(strip_tags($name)),
    //         ":email" => htmlspecialchars(strip_tags($email)),
    //         ":password" => password_hash($password, PASSWORD_DEFAULT),
    //         ":role" => $role,
    //         ":status" => $status
    //     ];

    //     if ($stmt->execute($params)) {
    //         return true;
    //     }
    //     return false;
    // }

    // sign up
    public function register($username, $email, $password) {
    
        if (empty($username) || empty($email) || empty($password)) {
            throw new Exception("All fields are required.");
        }
    
    
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            throw new Exception("Email already exists.");
        }
    
    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
    
        if ($stmt->execute()) {
            return true; 
        } else {
            throw new Exception("Database insertion failed."); 
        }
    }


    // Method to validate the user login credentials
    public function login($email, $password) {
        // Validate the input data
        if (empty($email) || empty($password)) {
            throw new Exception("Email and password are required.");
        }

        // Fetch the user data from the database
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user; // Return user data if credentials are correct
        } else {
            throw new Exception("Invalid email or password.");
        }
    }


    // public function login($email, $password): bool {
    //     $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
    //     $stmt = $this->pdo->prepare($query);
    //     $stmt->execute([":email" => $email]);

    //     if ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
    //         if (password_verify($password, $row['password'])) {
    //             $this->id = $row['id'];
    //             $this->name = $row['name'];
    //             $this->email = $row['email'];
    //             $this->role = $row['role'];
    //             return true;
    //         }
    //     }
    //     return false;
    // }
}

?>