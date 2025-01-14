<?php
namespace Models;
use Config\Database;
use PDO;

abstract class Model {
    public function create($table, $data) {
        $pdo = Database::makeconnection();
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_values($data));
        return $pdo->lastInsertId();
    }


    //update methode
    public function update($table, $data, $idColumn, $idValue) {
        $pdo = Database::makeconnection();
        $setClause = implode(', ', array_map(fn($col) => "$col = ?", array_keys($data)));
        $sql = "UPDATE $table SET $setClause WHERE $idColumn = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([...array_values($data), $idValue]);
        return $stmt->rowCount();
    }
    



    //delete method
    public function delete($table, $idColumn, $idValue) {
        $pdo = Database::makeconnection();
        $sql = "DELETE FROM $table WHERE $idColumn = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idValue]);
        return $stmt->rowCount();
    }


    //select
    public function select($table, $columns = "*", $where = null, $params = []) {
        $pdo = Database::makeconnection();
        $sql = "SELECT $columns FROM $table";
        if ($where) {
            $sql .= " WHERE $where";
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count($table) {
        $pdo = Database::makeConnection(); 
        $sql = "SELECT COUNT(*) FROM $table"; 
        $stmt = $pdo->prepare($sql); 
        $stmt->execute();  
        return $stmt->fetchColumn();  
    }
}
