<?php
$op = new Operations();

$get = Get();

$estados = $op->select('*', 'estados');

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
            <div class="profile-card">
                <div class="profile-header">
                    <img src="profile_placeholder.png" class="rounded-circle" width="150px" alt="User Image">
                    <h3 class="mt-3">User Name</h3>
                </div>
                <div class="profile-info mt-4">
                    <form class="edit-user">
                        <input type="hidden" name="id" value="user_id">

                        <div class="section-title">Informações Pessoais</div>
                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="nome"><i class="fa-solid fa-user"></i> Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome" value="User Name" placeholder="Digite o nome">
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="fa-solid fa-envelope"></i> Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="user@example.com" placeholder="Digite o email">
                            </div>
                            <div class="form-group">
                                <label for="telefone"><i class="fa-solid fa-phone"></i> Telefone:</label>
                                <input type="text" class="form-control" id="telefone" name="telefone" value="123-456-7890" placeholder="Digite o telefone">
                            </div>
                        </div>

                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="cpf"><i class="fa-solid fa-id-card"></i> CPF:</label>
                                <input type="text" class="form-control cpf" id="cpf" name="cpf" value="123.456.789-00" placeholder="Digite o CPF ou CNPJ">
                            </div>
                            <div class="form-group">
                                <label for="data_nascimento"><i class="fa-solid fa-birthday-cake"></i> Data de Nascimento:</label>
                                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="1990-01-01">
                            </div>
                            <div class="form-group">
                                <label for="sexo"><i class="fa-solid fa-genderless"></i> Sexo:</label>
                                <select class="form-select" id="sexo" name="sexo">
                                    <option selected value="M">Masculino</option>
                                    <option value="F">Feminino</option>
                                    <option value="O">Outro</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="estado_civil"><i class="fa-solid fa-heart"></i> Estado Civil:</label>
                            <select class="form-select" id="estado_civil" name="estado_civil">
                                <option selected value="solteiro">Solteiro</option>
                                <option value="casado">Casado</option>
                                <option value="divorciado">Divorciado</option>
                                <option value="viuvo">Viúvo</option>
                            </select>
                        </div>

                        <div class="section-title">Endereço</div>
                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="endereco"><i class="fa-solid fa-home"></i> Endereço:</label>
                                <input type="text" class="form-control" id="endereco" name="endereco" value="Rua Exemplo, 123" placeholder="Digite o endereço">
                            </div>
                            <div class="form-group">
                                <label for="numero"><i class="fa-solid fa-sort-numeric-up"></i> Nº:</label>
                                <input type="text" class="form-control form-control-short" id="numero" name="numero" value="123" placeholder="Digite o nº">
                            </div>
                            <div class="form-group">
                                <label for="bairro"><i class="fa-solid fa-city"></i> Bairro:</label>
                                <input type="text" class="form-control" id="bairro" name="bairro" value="Centro" placeholder="Digite o bairro">
                            </div>
                        </div>

                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="cidade"><i class="fa-solid fa-building"></i> Cidade:</label>
                                <input type="text" class="form-control" id="cidade" name="cidade" value="Cidade Exemplo" placeholder="Digite a cidade">
                            </div>
                            <div class="form-group">
                                <label for="estado"><i class="fa-solid fa-globe-americas"></i> Estado:</label>
                                <select class="form-select" id="estado" name="estado">
                                <option value="" selected>Selecione</option>
                                <?php if ($estados->affected_rows > 0): ?>
                                        <?php foreach ($estados->results as $estado): ?>
                                            <option value="<?= $estado->sigla ?>"><?= $estado->nome ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cep"><i class="fa-solid fa-map-pin"></i> CEP:</label>
                                <input type="text" class="form-control form-control-short" id="cep" name="cep" value="12345-678" placeholder="Digite o CEP">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="complemento"><i class="fa-solid fa-info-circle"></i> Complemento:</label>
                            <input type="text" class="form-control" id="complemento" name="complemento" value="Apto 45" placeholder="Digite o complemento">
                        </div>

                        <div class="section-title mt-4">Documentos Anexados</div>
                        <div class="form-group">
                            <div class="document-list">
                                <ul class="list-unstyled">
                                    <!-- Documento 1 -->
                                    <li class="document-item mb-3 d-flex align-items-center">
                                        <i class="fa-solid fa-file-pdf text-danger me-3" style="font-size: 24px;"></i>
                                        <a href="documento1.pdf" target="_blank" class="document-link">Documento 1.pdf</a>
                                        <button type="button" class="btn btn-outline-danger btn-sm ms-3">
                                            <i class="fa-solid fa-trash"></i> Excluir
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end m-3">
                            <button type="button" class="btn btn-danger sys-btn panel-btn me-2 deleta-usuario" data-id="user_id">Deletar usuário</button>
                            <button type="submit" class="btn btn-primary sys-btn panel-btn">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>