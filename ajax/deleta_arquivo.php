<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../_app/Config.inc.php";
require "../_app/urls.inc.php";
require "../classes/Helpers.inc.php";
require "../_app/Functions.inc.php";
require "../classes/Operations.inc.php";

use Midspace\Database;
use HelpersClass\SupAid;



$helpers = new SupAid();
$operations = new Operations();

if ($_SESSION['loggedUser'] != 1 || !isset($_SESSION['userId'])) {
    $response = [
        'status' => 'error',
        'message' => 'Usuário não autenticado.',
        'debug' => 'Usuário não está logado ou sessão inválida.'
    ];
    echo TreatedJson($response);
    return;
}

$post = Post();
$response = [];

if(empty($post->id)) {
    $response = [
        'status' => 'error',
        'message' => 'Usuário não autenticado.',
        'debug' => 'Usuário não está logado ou sessão inválida.'
    ];
    echo TreatedJson($response);
    return;
}

$fileId = $post->id;

$file = $operations->select(
      '*',
         'arquivos_anexados',
        'id = :id',
 [
               ':id' => $fileId
 ]);

$filePath = $file->results[0]->caminho_arquivo;

$results = $operations->delete(
    'arquivos_anexados',
    'id = :id',
    [':id' => $fileId]
);

if($results->affected_rows <= 0) {
    $response['status'] = 'error';
    $response['message'] = 'Ocorreu um erro ao tentar apagar o arquivo.';
    $response['title'] = "Erro!";

    echo TreatedJson($response);
    return;
}

if(!empty($filePath)) {
    if (file_exists($filePath)) {
        unlink($filePath);
        $response['status'] = 'success';
        $response['message'] = "Arquivo {$file->results[0]->nome_arquivo} deletado com sucesso!";
        $response['title'] = "Sucesso!";
        echo TreatedJson($response);
        return;
    }
}

