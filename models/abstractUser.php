<?php
namespace Models;

abstract class AbstractUser {
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

     // Method to register a user
     abstract public function register($username, $email, $password, $userType);


    // Method to validate the user login credentials
    abstract public function login($email, $password);

}


?>