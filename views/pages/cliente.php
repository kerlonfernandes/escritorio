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
        <?php if ($clienteResults->affected_rows > 0): ?>
            <div class="profile-card">
                <div class="profile-header">
                    <!-- <img src="profile_placeholder.png" class="rounded-circle" width="150px" alt="User Image"> -->
                    <h3 class="mt-3"><?= isset($cliente->nome) ? $cliente->nome : "Sem nome cadastrado" ?></h3>
                </div>
                <div class="profile-info mt-4">
                    <form class="edit-user" id="userForm">
                        <div class="d-flex justify-content-end m-3">
                            <button type="button" class="btn btn-primary" id="toggleEditButton" onclick="toggleEdit()">Editar</button>
                        </div>
                        <input type="hidden" name="id" value="<?= $get->id ?>">

                        <div class="section-title">Informações Pessoais</div>
                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="nome"><i class="fa-solid fa-user"></i> Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome" value="<?= isset($cliente->nome) ? $cliente->nome : "Sem nome" ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="fa-solid fa-envelope"></i> Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= isset($cliente->email) ? $cliente->email : "Sem email" ?>" placeholder="Digite o email" readonly>
                            </div>
                            <div class="form-group">
                                <label for="telefone"><i class="fa-solid fa-phone"></i> Telefone:</label>
                                <input type="text" class="form-control" id="telefone" name="telefone" value="<?= isset($cliente->telefone) ? $cliente->telefone : "Sem telefone cadastrado" ?>" placeholder="Digite o telefone" readonly>
                            </div>
                        </div>

                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="cpf"><i class="fa-solid fa-id-card"></i> CPF:</label>
                                <input type="text" class="form-control cpf" id="cpf" name="cpf" value="<?= isset($cliente->cpf) ? $cliente->cpf : "Sem cpf cadastrado" ?>" placeholder="Digite o CPF" readonly>
                            </div>

                            <div class="form-group">
                                <label for="data_nascimento"><i class="fa-solid fa-birthday-cake"></i> Data de Nascimento:</label>
                                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?= isset($cliente->data_nascimento) ? $cliente->data_nascimento : "Sem data cadastrada" ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="idade"><i class="fa-solid fa-birthday-cake"></i> Idade:</label>
                                <input type="number" class="form-control" name="idade" id="idade" value="<?= $cliente->idade ?>" readonly>
                            </div>

                        </div>
                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="rg"><i class="fa-solid fa-id-card"></i> RG:</label>
                                <input type="text" class="form-control rg" id="rg" name="rg" value="<?= isset($cliente->rg) ? $cliente->rg : "Sem rg cadastrado" ?>" placeholder="Digite o RG" readonly>
                            </div>
                            <div class="form-group">
                                <label for="rg"><i class="fa-solid fa-id-card"></i> Orgão Emissor:</label>
                                <input type="text" class="form-control orgao_emissor" id="orgao_emissor" name="orgao_emissor" value="<?= isset($cliente->orgao_emissor) ? $cliente->orgao_emissor : "Sem Orgão Emissor" ?>" placeholder="Digite o Orgão emissor" readonly>
                            </div>
                            <div class="form-group">
                                <label for="rg"><i class="fa-solid fa-id-card"></i> UF:</label>
                                <input type="text" class="form-control uf_rg" id="uf_rg" name="uf_rg" value="<?= isset($cliente->uf_rg) ? $cliente->uf_rg : "Sem UF cadastrado" ?>" placeholder="Digite o RG" readonly>
                            </div>
                            <div class="form-group">
                                <label for="estado"><i class="fa-solid fa-globe-americas"></i> Estado:</label>
                                <select class="form-select" id="uf" name="estado" disabled>
                                    <option value="<?= $cliente->estado ?>" selected><?= $cliente->estado ?></option>
                                    <?php if ($estados->affected_rows > 0): ?>
                                        <?php foreach ($estados->results as $estado): ?>
                                            <option value="<?= $estado->sigla ?>"><?= $estado->nome ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="estado_civil"><i class="fa-solid fa-heart"></i> Estado Civil:</label>
                                <select class="form-select" id="estado_civil" name="estado_civil" disabled>
                                    <option selected value="<?= $cliente->estado_civil ?>"><?= $cliente->estado_civil ?></option>
                                    <option value="solteiro">Solteiro</option>
                                    <option value="casado">Casado</option>
                                    <option value="divorciado">Divorciado</option>
                                    <option value="viuvo">Viúvo</option>
                                </select>
                                <label for="genero"><i class="fa-solid fa-genderless"></i> Gênero:</label>
                                <select class="form-select" id="genero" name="genero" disabled>
                                    <option selected value="<?= strtoupper($cliente->genero) ?>"><?= ($cliente->genero) ?></option>
                                    <option value="masculino">MASCULINO</option>
                                    <option value="feminino">FEMININO</option>
                                    <option value="outro">OUTRO</option>
                                </select>
                            </div>
                        </div>
                        <hr class="mt-4">
                        <div class="section-title">Informações:</div>
                        <?php
                        $fundacao = $cliente->fundacao;

                        $fundacaoArray = explode(',', $fundacao);
                        ?>

                        <label class="lbl-default">Fundação</label>
                        <div>
                            <input type="checkbox" name="fundacao[]" value="Mariana" id="mariana"
                                <?php echo in_array("Mariana", $fundacaoArray) ? 'checked' : ''; ?>>
                            <label for="mariana">Mariana</label>
                        </div>
                        <div>
                            <input type="checkbox" name="fundacao[]" value="Renova" id="renova"
                                <?php echo in_array("Renova", $fundacaoArray) ? 'checked' : ''; ?>>
                            <label for="renova">Renova</label>
                        </div>
                        <div class="form-group col-md-5 mt-4">
                            <label for="senha_portal"><i class="fa-solid fa-id-card"></i> Senha do Portal:</label>
                            <input type="text" class="form-control rg" id="senha_portal" name="senha_portal" value="<?= isset($cliente->senha_portal) ? $cliente->senha_portal : "Sem Senha cadastrada" ?>" placeholder="Digite a Senha do portal" readonly>
                        </div>
                        <hr class="mt-4">
                        <div class="section-title">Dados de endereço:</div>
                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="endereco"><i class="fa-solid fa-home"></i> Rua:</label>
                                <input type="text" class="form-control" id="rua" name="rua" value="<?= isset($cliente->rua) ? $cliente->rua : "Sem rua cadastrada" ?>" placeholder="Digite o endereço" readonly>
                            </div>
                            <div class="form-group">
                                <label for="numero"><i class="fa-solid fa-sort-numeric-up"></i> Nº:</label>
                                <input type="text" class="form-control form-control-short" id="numero" name="numero" value="<?= isset($cliente->numero) ? $cliente->numero : "Sem numero cadastrado" ?>" placeholder="Digite o nº" readonly>
                            </div>
                            <div class="form-group">
                                <label for="bairro"><i class="fa-solid fa-city"></i> Bairro:</label>
                                <input type="text" class="form-control" id="bairro" name="bairro" value="<?= isset($cliente->bairro) ? $cliente->bairro : "Sem bairro cadastrado" ?>" placeholder="Digite o bairro" readonly>
                            </div>
                        </div>

                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="cidade"><i class="fa-solid fa-building"></i> Cidade:</label>
                                <input type="text" class="form-control" id="cidade" name="cidade" value="<?= isset($cliente->cidade) ? $cliente->cidade : "Sem cidade cadastrada" ?>" placeholder="Digite a cidade" readonly>
                            </div>

                            <div class="form-group">
                                <label for="cep"><i class="fa-solid fa-map-pin"></i> CEP:</label>
                                <input type="text" class="form-control form-control-short" id="cep" name="cep" value="<?= isset($cliente->cep) ? $cliente->cep : "Sem cep cadastrado" ?>" placeholder="Digite o CEP" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="complemento"><i class="fa-solid fa-info-circle"></i> Complemento:</label>
                            <input type="text" class="form-control" id="complemento" name="complemento" value="<?= isset($cliente->complemento) ? $cliente->complemento : "Sem complemento" ?>" placeholder="Digite o complemento" readonly>
                        </div>

                        <hr class="mt-4">
                        <div class="section-title mt-4">Documentos Anexados</div>
                        <div class="form-group">
                            <div class="document-list">
                                <ul class="list-unstyled">
                                    <?php if ($arquivosResults->affected_rows > 0): ?>
                                        <?php foreach ($arquivosResults->results as $arquivo): ?>
                                            <li class="document-item mb-3 d-flex align-items-center">
                                                <i class="fa-solid fa-file-pdf text-danger me-3" style="font-size: 24px;"></i>
                                                <a href="<?= $arquivo->caminho_arquivo ?>" target="_blank" class="document-link"><?= $arquivo->nome_arquivo ?></a>
                                                <button type="button" class="btn btn-outline-danger btn-sm ms-auto deletar-arquivo" data-id="<?= $arquivo->id ?>" data-file="<?= $arquivo->nome_arquivo ?>">
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

                        <div class="form-group mt-3">
                            <label for="documentos"><i class="fa-solid fa-upload"></i> Adicionar novo arquivo:</label>
                            <input type="file" class="form-control" id="documentos" name="documentos[]" multiple>
                        </div>
                    </form>

                </div>
            </div>
        <?php endif; ?>
    </div>
</div>