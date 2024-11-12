<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/Database.inc.php');

use Midspace\Database;

class Operations {
    public Database $database;

    public function __construct() {
        $this->database = new Database(MYSQL_CONFIG);
    }

    public function select(string $columns = "*", string $from = "", string $where = "", array $parameters = []): ?object {
        $sql = "SELECT $columns FROM $from";
        if (!empty($where)) {
            $sql .= " WHERE $where";
        }
        return $this->database->execute_query($sql, $parameters);
    }

    public function insert(string $table, array $data): ?object {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_map(fn($key) => ":$key", array_keys($data)));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        return $this->database->execute_non_query($sql, $data);
    }

    public function update(string $table, array $data, string $where = "", array $parameters = []): ?object {
        $setClause = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $sql = "UPDATE $table SET $setClause";

        if (!empty($where)) {
            $sql .= " WHERE $where";
        }

        return $this->database->execute_non_query($sql, array_merge($data, $parameters));
    }

    public function delete(string $table, string $where, array $parameters): ?object {
        $sql = "DELETE FROM $table WHERE $where";
        return $this->database->execute_non_query($sql, $parameters);
    }

}


// Exemplo de uso do select com placeholders nomeados
// $result = $op->select("users", "users", "name = :name", [":name" => "Kerlon"]);
// print_r($result->data);




// Exemplo de uso do insert com placeholders nomeados
// $insertData = [
//     "name" => "Kerlon",
//     "email" => "kerlon1221@gmail.com"
// ];
// $result = $op->insert("users", $insertData);
// print_r($result->data);




// Exemplo de uso do update com placeholders nomeados
// $updateData = [
//     "name" => "Kerlon"
// ];
// $result = $op->update("users", $updateData, "id = :id", [":id" => 1]);
// print_r($result->data);




// Exemplo de uso do delete com placeholders nomeados
// $result = $op->delete("users", "name = :name", [":name" => "Kerlon"]);
// print_r($result->data);
