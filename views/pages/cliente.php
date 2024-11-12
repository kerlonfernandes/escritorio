<?php
$op = new Operations();
$session = Session();
$get = Get();

if (empty($get->id)) {
    return;
}

$estados = $op->select('*', 'estados');

$clienteResults = $op->database->execute_query('
SELECT * FROM clientes
JOIN enderecos_clientes ON enderecos_clientes.cliente_id = clientes.id
WHERE clientes.user_id = :id AND clientes.id = :cliente
', [':id' => $session->userId, ':cliente' => $get->id]);

$cliente = $clienteResults->results[0];

$arquivosResults = $op->database->execute_query('
    SELECT * FROM arquivos_anexados WHERE cliente_id = :cliente_id AND user_id = :user_id
', [':user_id' => $session->userId, ':cliente_id' => $get->id]);

// print_r($cliente);
?>

<style>
    .document-list {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        background-color: #f9f9f9;
    }

    .document-item {
        border-bottom: 1px solid #ddd;
        padding: 10px;
        background-color: #fff;
        border-radius: 6px;
        transition: background-color 0.3s;
    }

    .document-item:hover {
        background-color: #f0f0f0;
    }

    .document-link {
        font-size: 16px;
        font-weight: 600;
        color: #007bff;
        text-decoration: none;
    }

    .document-link:hover {
        text-decoration: underline;
    }

    .btn-outline-danger {
        border: 1px solid #dc3545;
        color: #dc3545;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    .form-control-short {
        width: 150px;
    }

    .form-group-inline {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .form-group-inline .form-group {
        flex: 1 1 calc(33.33% - 10px);
        margin-bottom: 15px;
    }

    .form-group-inline .form-group:last-child {
        margin-right: 0;
    }

    .section-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .form-select,
    .form-control {
        width: 100%;
    }

    .form-group label {
        font-weight: 600;
    }

    .d-flex .btn {
        width: 248px;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <?php if ($clienteResults->affected_rows > 0): ?>
                <div class="profile-card">
                    <div class="profile-header">
                        <!-- <img src="profile_placeholder.png" class="rounded-circle" width="150px" alt="User Image"> -->
                        <h3 class="mt-3"><?= isset($cliente->nome) ? $cliente->nome : "Sem nome cadastrado" ?></h3>
                    </div>
                    <div class="profile-info mt-4">
                        <form class="edit-user">
                            <input type="hidden" name="id" value="<?= $cliente->id ?>">

                            <div class="section-title">Informações Pessoais</div>
                            <div class="form-group-inline">
                                <div class="form-group">
                                    <label for="nome"><i class="fa-solid fa-user"></i> Nome:</label>
                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome" value="<?= isset($cliente->nome) ? $cliente->nome : "Sem nome" ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email"><i class="fa-solid fa-envelope"></i> Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= isset($cliente->email) ? $cliente->email : "Sem email" ?>" placeholder="Digite o email">
                                </div>
                                <div class="form-group">
                                    <label for="telefone"><i class="fa-solid fa-phone"></i> Telefone:</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?= isset($cliente->telefone) ? $cliente->telefone : "Sem telefone cadastrado" ?>" placeholder="Digite o telefone">
                                </div>
                            </div>

                            <div class="form-group-inline">
                                <div class="form-group">
                                    <label for="cpf"><i class="fa-solid fa-id-card"></i> CPF:</label>
                                    <input type="text" class="form-control cpf" id="cpf" name="cpf" value="<?= isset($cliente->cpf) ? $cliente->cpf : "Sem cpf cadastrado" ?>" placeholder="Digite o CPF">
                                </div>
                                <div class="form-group">
                                    <label for="data_nascimento"><i class="fa-solid fa-birthday-cake"></i> Data de Nascimento:</label>
                                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?= isset($cliente->data_nascimento) ? $cliente->data_nascimento : "Sem data cadastrada" ?>">
                                </div>
                                <div class="form-group">
                                    <label for="sexo"><i class="fa-solid fa-genderless"></i> Sexo:</label>
                                    <select class="form-select" id="sexo" name="sexo">
                                        <option selected value="<?= strtoupper($cliente->genero) ?>"><?= ($cliente->genero) ?></option>
                                        <option value="masculino">MASCULINO</option>
                                        <option value="F">FEMININO</option>
                                        <option value="O">OUTRO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="estado_civil"><i class="fa-solid fa-heart"></i> Estado Civil:</label>
                                <select class="form-select" id="estado_civil" name="estado_civil">

                                    <option selected value="<?= $cliente->estado_civil ?>"><?= $cliente->estado_civil ?></option>
                                    <option selected value="solteiro">Solteiro</option>
                                    <option value="casado">Casado</option>
                                    <option value="divorciado">Divorciado</option>
                                    <option value="viuvo">Viúvo</option>
                                </select>
                            </div>

                            <div class="section-title">Dados de endereço:</div>
                            <div class="form-group-inline">
                                <div class="form-group">
                                    <label for="endereco"><i class="fa-solid fa-home"></i> Rua:</label>
                                    <input type="text" class="form-control" id="rua" name="rua" value="<?= isset($cliente->rua) ? $cliente->rua : "Sem rua cadastrada" ?>" placeholder="Digite o endereço">
                                </div>
                                <div class="form-group">
                                    <label for="numero"><i class="fa-solid fa-sort-numeric-up"></i> Nº:</label>
                                    <input type="text" class="form-control form-control-short" id="numero" name="numero" value="<?= isset($cliente->numero) ? $cliente->numero : "Sem numero cadastrado" ?>" placeholder="Digite o nº">
                                </div>
                                <div class="form-group">
                                    <label for="bairro"><i class="fa-solid fa-city"></i> Bairro:</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" value="<?= isset($cliente->bairro) ? $cliente->bairro : "Sem bairro cadastrado" ?>" placeholder="Digite o bairro">
                                </div>
                            </div>

                            <div class="form-group-inline">
                                <div class="form-group">
                                    <label for="cidade"><i class="fa-solid fa-building"></i> Cidade:</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" value="<?= isset($cliente->cidade) ? $cliente->cidade : "Sem cidade cadastrada" ?>" placeholder="Digite a cidade">
                                </div>
                                <div class="form-group">
                                    <label for="estado"><i class="fa-solid fa-globe-americas"></i> Estado:</label>
                                    <select class="form-select" id="estado" name="estado">
                                        <option value="<?= $cliente->estado ?>" selected><?= $cliente->estado ?></option>
                                        <?php if ($estados->affected_rows > 0): ?>
                                            <?php foreach ($estados->results as $estado): ?>
                                                <option value="<?= $estado->sigla ?>"><?= $estado->nome ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cep"><i class="fa-solid fa-map-pin"></i> CEP:</label>
                                    <input type="text" class="form-control form-control-short" id="cep" name="cep" value="<?= isset($cliente->cep) ? $cliente->cep : "Sem cep cadastrado" ?>" placeholder="Digite o CEP">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="complemento"><i class="fa-solid fa-info-circle"></i> Complemento:</label>
                                <input type="text" class="form-control" id="complemento" name="complemento" value="<?= isset($cliente->complemento) ? $cliente->complemento : "Sem complemento" ?>" placeholder="Digite o complemento">
                            </div>

                            <div class="section-title mt-4">Documentos Anexados</div>
                            <div class="form-group">
                                <div class="document-list">
                                    <ul class="list-unstyled">
                                        <?php if ($arquivosResults->affected_rows > 0): ?>
                                            <?php foreach ($arquivosResults->results as $arquivo): ?>
                                                <li class="document-item mb-3 d-flex align-items-center">
                                                    <i class="fa-solid fa-file-pdf text-danger me-3" style="font-size: 24px;"></i>
                                                    <a href="<?= $arquivo->caminho_arquivo ?>" target="_blank" class="document-link"><?= $arquivo->nome_arquivo ?></a>
                                                    <button type="button" class="btn btn-outline-danger btn-sm ms-auto" data-id="<?= $arquivo->id ?>">
                                                        <i class="fa-solid fa-trash"></i> Excluir
                                                    </button>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span>Sem arquivos anexados</span>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- Campo para upload de novos arquivos -->
                            <div class="form-group mt-3">
                                <label for="novo_arquivo"><i class="fa-solid fa-upload"></i> Adicionar novo arquivo:</label>
                                <input type="file" class="form-control" id="novo_arquivo" name="novo_arquivo[]" multiple>
                            </div>
                            <div class="d-flex justify-content-end m-3">
                                <button type="button" class="btn btn-danger sys-btn panel-btn me-2 deleta-usuario" data-id="user_id">Deletar usuário</button>
                                <button type="submit" class="btn btn-primary sys-btn panel-btn">Editar</button>
                            </div>

                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>