<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../_app/Config.inc.php";  // Configuração do banco de dados
require "../classes/Helpers.inc.php";  // Funções auxiliares
require "../_app/Functions.inc.php";  // Funções personalizadas
require "../classes/Database.inc.php";  // Classe de conexão com o banco

use Midspace\Database;
use HelpersClass\SupAid;

header_json();

$helpers = new SupAid();

// Verificar se o usuário está autenticado
if ($_SESSION['loggedUser'] != 1 || !isset($_SESSION['userId'])) {
    $response = [
        'status' => 'error',
        'message' => 'Usuário não autenticado.',
        'debug' => 'Usuário não está logado ou sessão inválida.'
    ];
    echo json_encode($response);
    return;
}

$post = Post();
$response = [];

if (isset($post->clienteId)) {
    $clienteId = $post->clienteId;

    try {
        $db = new Database(MYSQL_CONFIG);

        $db->execute_non_query("SET foreign_key_checks = 0");

        $selectArquivosSql = "SELECT caminho_arquivo FROM arquivos_anexados WHERE cliente_id = :cliente_id";
        $arquivos = $db->execute_query($selectArquivosSql, [':cliente_id' => $clienteId]);

        foreach ($arquivos->results as $arquivo) {
            if (file_exists($arquivo->caminho_arquivo)) {
                unlink($arquivo->caminho_arquivo);
            }
        }
        $deleteArquivosSql = "DELETE FROM arquivos_anexados WHERE cliente_id = :cliente_id";
        $deleteEnderecosSql = "DELETE FROM enderecos_clientes WHERE cliente_id = :cliente_id";
        $params = [':cliente_id' => $clienteId];

        $db->execute_non_query($deleteArquivosSql, $params);
        $db->execute_non_query($deleteEnderecosSql, $params);

        $deleteClienteSql = "DELETE FROM clientes WHERE id = :cliente_id";
        $result = $db->execute_non_query($deleteClienteSql, $params);

        $db->execute_non_query("SET foreign_key_checks = 1");

        if ($result->status == 'success') {
            $response['status'] = 'success';
            $response['message'] = 'Cliente e dados relacionados excluídos com sucesso.';
            $response['title'] = 'Sucesso!';

        } else {
            throw new Exception('Falha ao excluir o cliente.');
        }
    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = 'Erro ao excluir o cliente.';
        $response['debug'] = $e->getMessage() . ' | ' . $e->getTraceAsString();
    }

    echo json_encode($response);
}
?>
