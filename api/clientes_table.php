<?php

session_start();

header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../classes/Operations.inc.php");
require_once("../_app/Config.inc.php");

use Operations;

$op = new Operations();

if (!isset($_SESSION['loggedUser']) || $_SESSION['loggedUser'] !== true) {
    echo json_encode([
        "status" => "error",
        "message" => "User not logged in.",
    ]);
    exit;
}

$start = isset($_GET['start']) ? (int) $_GET['start'] : 0;
$length = isset($_GET['length']) ? (int) $_GET['length'] : 10; 
$filterField = isset($_GET['filterField']) ? $_GET['filterField'] : '';
$searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';

$orderColumn = isset($_GET['orderColumn']) ? $_GET['orderColumn'] : 'id';  // Coluna para ordenação (default: id)
$orderDir = isset($_GET['orderDir']) ? $_GET['orderDir'] : 'asc';

$table = 'clientes';

$userId = $_SESSION['userId'];

$whereClause = "user_id = :userId";
$parameters = [':userId' => $userId];

if ($filterField && $searchTerm) {
    $whereClause .= " AND $filterField LIKE :searchTerm";
    $parameters[':searchTerm'] = '%' . $searchTerm . '%';
}

$selectColumns = "clientes.*, enderecos_clientes.*";

$sql = "SELECT $selectColumns FROM $table 
        LEFT JOIN enderecos_clientes 
        ON enderecos_clientes.cliente_id = clientes.id 
        WHERE $whereClause";

$result = $op->database->execute_query($sql, $parameters);

if ($result === false || !isset($result->status) || $result->status !== 'success') {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to fetch data from the database.",
    ]);
    exit;
}

$data = $result->results;

if (isset($data[0]->$orderColumn)) {
    usort($data, function ($a, $b) use ($orderColumn, $orderDir) {
        if ($orderDir === 'asc') {
            return strcmp($a->$orderColumn, $b->$orderColumn);
        } else {
            return strcmp($b->$orderColumn, $a->$orderColumn);
        }
    });
} else {
    $orderColumn = 'id';
    $orderDir = 'asc';
}

foreach ($data as &$row) {
    if (empty($row->nome) || empty($row->cpf) || empty($row->telefone)  || empty($row->senha_portal)  || empty($row->genero)  || empty($row->fundacao) || empty($row->fundacao) || empty($row->rg) || empty($row->estado_civil) || empty($row->cidade)) {
        $row->situacao = '<div class="alert alert-danger" style="border:none; padding:2px; font-weight:bold;" role="alert">Incompleto</div>';
    } else {
        $row->situacao = '<div class="alert alert-primary" style="border:none; padding:2px; font-weight:bold;" role="alert">Completo</div>';
    }
}

$paginatedData = array_slice($data, $start, $length);
$totalRecords = count($data);

echo json_encode([
    "draw" => isset($_GET['draw']) ? $_GET['draw'] : 1,
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalRecords,
    "data" => $paginatedData
]);
