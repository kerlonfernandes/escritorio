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

$post = Post();  // Recebe os dados do formulário
$response = [];

// Verificar se os campos obrigatórios foram preenchidos
if (empty($post->nome_completo) || empty($post->data_nascimento) || empty($post->idade) || empty($post->genero) || empty($post->telefone)) {
    $response['status'] = 'error';
    $response['message'] = 'Preencha todos os campos obrigatórios!';
    $response['debug'] = 'Campos obrigatórios não preenchidos.';
    echo json_encode($response);
    return;
}

$fundacaoStr = is_array($post->fundacao) ? implode(",", $post->fundacao) : $post->fundacao;

try {
    $clienteInsertSql = "INSERT INTO clientes (user_id, nome, estado_civil, genero, idade, cpf, rg, telefone, email, senha_portal, fundacao, data_nascimento)
                         VALUES (:user_id, :nome_completo, :estado_civil, :genero, :idade, :cpf, :rg, :telefone, :email, :senha_portal, :fundacao, :data_nascimento)";

    // Parâmetros da consulta
    $params = [
        ':user_id' => $_SESSION['userId'],
        ':nome_completo' => $post->nome_completo,
        ':data_nascimento' => $post->data_nascimento,
        ':idade' => $post->idade,
        ':genero' => $post->genero,
        ':estado_civil' => isset($post->estado_civil) ? $post->estado_civil : null,
        ':telefone' => $post->telefone,
        ':email' => isset($post->email) ? $post->email : null,
        ':senha_portal' => isset($post->senha_portal) ? $post->senha_portal : null,
        ':fundacao' => isset($fundacaoStr) ?  $fundacaoStr : null,
        ':cpf' => isset($post->cpf) ? $post->cpf : null,
        ':rg' => isset($post->rg) ? $post->rg : null
    ];

    $db = new Database(MYSQL_CONFIG);
    $clientResults = $db->execute_non_query($clienteInsertSql, $params);
    if ($clientResults->status != 'success') {
        throw new Exception('Falha ao executar a inserção do cliente.');
    }

    $clienteId = $clientResults->last_id;
} catch (Exception $e) {
    // Captura o erro detalhado e mostra no JSON
    $response['status'] = 'error';
    $response['message'] = 'Erro ao cadastrar cliente.';
    $response['debug'] = 'Erro na inserção do cliente: ' . $e->getMessage() . ' | ' . $e->getTraceAsString();
    echo json_encode($response);
    return;
}

try {
    $enderecoInsertSql = "INSERT INTO enderecos_clientes (cliente_id, rua, numero, complemento, bairro, cidade, estado, cep)
                          VALUES (:cliente_id, :rua, :numero, :complemento, :bairro, :cidade, :estado, :cep)";
    $params = [
        ':cliente_id' => $clienteId,
        ':rua' => isset($post->rua) ? $post->rua : null,
        ':numero' => isset($post->numero) ? $post->numero : null,
        ':complemento' => isset($post->complemento) ? $post->complemento : null,
        ':bairro' => isset($post->bairro) ? $post->bairro : null,
        ':cidade' => isset($post->cidade) ? $post->cidade : null,
        ':estado' => isset($post->uf) ? $post->uf : null,  // 'uf' é o estado
        ':cep' => isset($post->cep) ? $post->cep : null,
    ];

    if (!$db->execute_non_query($enderecoInsertSql, $params)) {
        throw new Exception('Falha ao executar a inserção do endereço.');
    }
} catch (Exception $e) {
    // Captura o erro detalhado e mostra no JSON
    $response['status'] = 'error';
    $response['message'] = 'Erro ao cadastrar o endereço.';
    $response['debug'] = 'Erro na inserção do endereço: ' . $e->getMessage() . ' | ' . $e->getTraceAsString();
    echo json_encode($response);
    return;
}

try {
    $documentos = isset($_FILES['documentos']) && is_array($_FILES['documentos']['error']) ? $_FILES['documentos'] : null;

    if ($documentos) {
        $filePaths = [];
        $userId = $_SESSION['userId'];

        // Verificar se há múltiplos arquivos
        if (isset($documentos['name']) && is_array($documentos['name'])) {
            foreach ($documentos['name'] as $index => $fileName) {
                if ($documentos['error'][$index] == 0) {
                    $fileTmpPath = $documentos['tmp_name'][$index];
                    $fileSize = $documentos['size'][$index];
                    $fileType = $documentos['type'][$index];

                    // Verificação do tipo e tamanho do arquivo
                    if ($fileType != 'application/pdf') {
                        throw new Exception('Arquivo deve ser em formato PDF.');
                    }
                    if ($fileSize > 5000000) { // Limitar o tamanho do arquivo para 5MB
                        throw new Exception('O arquivo é muito grande. O tamanho máximo permitido é 5MB.');
                    }

                    $uploadDir = "../app/uploads/pdf/";
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $filePath = $uploadDir . uniqid() . "_" . basename($fileName);
                    // Garantir que o diretório exista
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $filePath = $uploadDir . uniqid() . "_" . basename($fileName);

                    if (move_uploaded_file($fileTmpPath, $filePath)) {
                        // Inserir o arquivo no banco de dados
                        $fileInsertSql = "INSERT INTO arquivos_anexados (user_id, cliente_id, nome_arquivo, tipo_arquivo, tamanho_arquivo, caminho_arquivo)
                                          VALUES (:user_id, :cliente_id, :nome_arquivo, :tipo_arquivo, :tamanho_arquivo, :caminho_arquivo)";
                        $params = [
                            ':user_id' => $userId,
                            ':cliente_id' => $clienteId,
                            ':nome_arquivo' => $fileName,
                            ':tipo_arquivo' => $fileType,
                            ':tamanho_arquivo' => $fileSize,
                            ':caminho_arquivo' => $filePath,
                        ];
                        $db->execute_non_query($fileInsertSql, $params);
                        $filePaths[] = $filePath;
                    } else {
                        throw new Exception('Falha ao mover o arquivo para o diretório de upload: ' . $fileName);
                    }
                } else {
                    throw new Exception('Erro no envio do arquivo: ' . $documentos['error'][$index]);
                }
            }
        } else {
            // Caso seja apenas um arquivo
            if ($documentos['error'] == 0) {
                $fileTmpPath = $documentos['tmp_name'];
                $fileSize = $documentos['size'];
                $fileType = $documentos['type'];
                $fileName = $documentos['name'];

                // Verificação do tipo e tamanho do arquivo
                if ($fileType != 'application/pdf') {
                    throw new Exception('Arquivo deve ser em formato PDF.');
                }
                if ($fileSize > 5000000) { // Limitar o tamanho do arquivo para 5MB
                    throw new Exception('O arquivo é muito grande. O tamanho máximo permitido é 5MB.');
                }

                $uploadDir = "../app/uploads/pdf/";
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $filePath = $uploadDir . uniqid() . "_" . basename($fileName);

                if (move_uploaded_file($fileTmpPath, $filePath)) {
                    $fileInsertSql = "INSERT INTO arquivos_anexados (user_id, cliente_id, nome_arquivo, tipo_arquivo, tamanho_arquivo, caminho_arquivo)
                                      VALUES (:user_id, :cliente_id, :nome_arquivo, :tipo_arquivo, :tamanho_arquivo, :caminho_arquivo)";
                    $params = [
                        ':user_id' => $userId,
                        ':cliente_id' => $clienteId,
                        ':nome_arquivo' => $fileName,
                        ':tipo_arquivo' => $fileType,
                        ':tamanho_arquivo' => $fileSize,
                        ':caminho_arquivo' => $filePath,
                    ];
                    $db->execute_non_query($fileInsertSql, $params);
                    $filePaths[] = $filePath;
                } else {
                    throw new Exception('Falha ao mover o arquivo para o diretório de upload: ' . $fileName);
                }
            }
        }
    } else {
        throw new Exception('Nenhum arquivo foi enviado.');
    }

    // Resposta final de sucesso
    $response['status'] = 'success';
    $response['message'] = 'Cadastro realizado com sucesso!';
    $response['cliente_id'] = $clienteId;
    $response['debug'] = 'Cliente e arquivo(s) cadastrados com sucesso.';
    echo json_encode($response);
} catch (Exception $e) {
    // Captura o erro detalhado e mostra no JSON
    $response['status'] = 'error';
    $response['message'] = 'Erro ao processar a solicitação.';
    $response['debug'] = $e->getMessage() . ' | ' . $e->getTraceAsString();
    echo json_encode($response);
}
