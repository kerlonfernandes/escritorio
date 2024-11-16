<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../_app/Config.inc.php";
require "../classes/Helpers.inc.php";
require "../_app/Functions.inc.php";
require "../classes/Database.inc.php";
header_json();

use Midspace\Database;
use HelpersClass\SupAid;

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

if (empty($post->id)) {
    $response['status'] = 'error';
    $response['message'] = 'ID do cliente não fornecido.';
    echo json_encode($response);
    return;
}

$clienteId = $post->id;

$fundacaoStr = is_array($post->fundacao) ? implode(",", $post->fundacao) : $post->fundacao;

try {
    $clienteUpdateSql = "UPDATE clientes SET nome = :nome, estado_civil = :estado_civil, genero = :genero, idade = :idade,
                         cpf = :cpf, rg = :rg, orgao_emissor = :orgao_emissor, uf_rg = :uf_rg, telefone = :telefone, email = :email, senha_portal = :senha_portal, fundacao = :fundacao, data_nascimento = :data_nascimento
                         WHERE id = :cliente_id";

    $params = [
        ':cliente_id' => $clienteId,
        ':nome' => $post->nome,
        ':estado_civil' => $post->estado_civil,
        ':genero' => $post->genero,
        ':idade' => $post->idade,
        ':cpf' => $post->cpf,
        ':telefone' => $post->telefone,
        ':email' => $post->email,
        ':senha_portal' => $post->senha_portal,
        ':data_nascimento' => $post->data_nascimento,
        ':rg' => $post->rg,
        ':orgao_emissor' => $post->orgao_emissor,
        ':uf_rg' => $post->uf_rg,
        ':fundacao' => isset($fundacaoStr) ?  $fundacaoStr : null,


    ];

    $db = new Database(MYSQL_CONFIG);
    $update = $db->execute_non_query($clienteUpdateSql, $params);
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = 'Erro ao atualizar dados do cliente.';
    $response['debug'] = $e->getMessage();
    echo json_encode($response);
    return;
}

// Atualizar endereço do cliente
try {
    $enderecoUpdateSql = "UPDATE enderecos_clientes SET rua = :rua, numero = :numero, complemento = :complemento, bairro = :bairro,
                          cidade = :cidade, estado = :estado, cep = :cep WHERE cliente_id = :cliente_id";

    $params = [
        ':cliente_id' => $clienteId,
        ':rua' => $post->rua,
        ':numero' => $post->numero,
        ':complemento' => $post->complemento,
        ':bairro' => $post->bairro,
        ':cidade' => $post->cidade,
        ':estado' => $post->estado,
        ':cep' => $post->cep
    ];

    $db->execute_non_query($enderecoUpdateSql, $params);
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = 'Erro ao atualizar o endereço do cliente.';
    $response['debug'] = $e->getMessage();
    echo json_encode($response);
    return;
}

// Processar arquivos anexados
try {
    if (isset($_FILES['documentos']) && is_array($_FILES['documentos']['name'])) {
        foreach ($_FILES['documentos']['name'] as $index => $fileName) {
            if ($_FILES['documentos']['error'][$index] == UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['documentos']['tmp_name'][$index];
                $fileSize = $_FILES['documentos']['size'][$index];
                $fileType = $_FILES['documentos']['type'][$index];

                // Verificação de tipo e tamanho do arquivo
                if ($fileType != 'application/pdf') {
                    throw new Exception("Arquivo deve ser em formato PDF. Erro no arquivo $fileName");
                }
                if ($fileSize > 100000000) {
                    throw new Exception("O arquivo é muito grande. Tamanho máximo permitido é 5MB. Erro no arquivo $fileName");
                }

                // Configuração do diretório de upload
                $uploadDir = "../app/uploads/pdf/";
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Nome do arquivo e caminho
                $filePath = $uploadDir . uniqid() . "_" . basename($fileName);

                // Move o arquivo para o diretório
                if (move_uploaded_file($fileTmpPath, $filePath)) {
                    // Insere os dados do arquivo no banco de dados
                    $fileInsertSql = "INSERT INTO arquivos_anexados (user_id, cliente_id, nome_arquivo, tipo_arquivo, tamanho_arquivo, caminho_arquivo)
                                      VALUES (:user_id, :cliente_id, :nome_arquivo, :tipo_arquivo, :tamanho_arquivo, :caminho_arquivo)";
                    $params = [
                        ':user_id' => $_SESSION['userId'],
                        ':cliente_id' => $clienteId,
                        ':nome_arquivo' => $fileName,
                        ':tipo_arquivo' => $fileType,
                        ':tamanho_arquivo' => $fileSize,
                        ':caminho_arquivo' => $filePath
                    ];
                    $db->execute_non_query($fileInsertSql, $params);
                } else {
                    throw new Exception("Falha ao mover o arquivo: $fileName");
                }
            }
        }
    }

    $response['status'] = 'success';
    $response['message'] = 'Dados do cliente atualizados com sucesso!';
    echo json_encode($response);
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = 'Erro ao processar arquivos.';
    $response['debug'] = $e->getMessage();
    echo json_encode($response);
}
