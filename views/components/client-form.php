<style>
    .nav-link {
        background: none !important;
    }

    .formulario-cadastrar-cliente {
        padding: 25px;
    }
</style>
<div class="container formulario-cadastrar-cliente">
    <h2 class="sec-title">Cadastro do Cliente</h2>

    <form id="client-form" class="mt-5">
        <div id="smartwizard">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link" href="#step-1">
                        <div class="num">1</div>Informações do Cliente
                    </a></li>
                <li class="nav-item"><a class="nav-link" href="#step-2"><span class="num">2</span>Informações de Contato</a></li>
                <li class="nav-item"><a class="nav-link" href="#step-3"><span class="num">3</span>Informações de Endereço</a></li>
                <li class="nav-item"><a class="nav-link" href="#step-4"><span class="num">4</span>Documentos</a></li>
            </ul>

            <div class="tab-content mt-4">
                <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label class="lbl-default">Nome Completo</label>
                                <input type="text" class="form-control" name="nome_completo" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-grp">
                                <label class="lbl-default">Data de Nascimento</label>
                                <input type="date" class="form-control" name="data_nascimento" id="data_nascimento">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-grp">
                                <label class="lbl-default">Idade</label>
                                <input type="number" class="form-control" name="idade" id="idade">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label class="lbl-default">Gênero</label>
                                <select class="form-select" name="genero" required>
                                    <option value="">Selecione</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="feminino">Feminino</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label class="lbl-default">Estado Civil</label>
                                <select class="form-select" name="estado_civil">
                                    <option value="">Selecione</option>
                                    <option value="solteiro">Solteiro</option>
                                    <option value="casado">Casado</option>
                                    <option value="divorciado">Divorciado</option>
                                    <option value="viuvo">Viúvo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label class="lbl-default">CPF</label>
                                <input type="text" class="form-control cpf" name="cpf" maxlength="14" id="cpf" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label class="lbl-default">RG</label>
                                <input type="text" class="form-control rg" name="rg" id="rg">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label class="lbl-default">Cadastro por</label>
                                <div>
                                    <input type="checkbox" name="fundacao[]" value="Mariana" id="mariana">
                                    <label for="mariana">Mariana</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="fundacao[]" value="Renova" id="renova">
                                    <label for="renova">Renova</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label class="lbl-default">
                                    <div class="alert alert-warning" role="alert">
                                        Senha do portal
                                    </div>
                                </label>
                                <input type="text" class="form-control" name="senha_portal">
                            </div>
                        </div>
                    </div>
                </div>

                <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label class="lbl-default">Telefone</label>
                                <input type="tel" class="form-control celular" name="telefone" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label class="lbl-default">E-mail</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                        </div>
                    </div>
                </div>

                <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label class="lbl-default">Nome da Rua</label>
                                <input type="text" class="form-control" name="rua">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-grp">
                                <label class="lbl-default">Número</label>
                                <input type="text" class="form-control" name="numero">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-grp">
                                <label class="lbl-default">Bairro</label>
                                <input type="text" class="form-control" name="bairro">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label class="lbl-default">Cidade</label>
                                <input type="text" class="form-control" name="cidade">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-grp">
                                <label class="lbl-default">UF</label>
                                <select class="form-select" name="uf">
                                    <option value="" selected>Selecione</option>
                                    <?php if ($estados->affected_rows > 0): ?>
                                        <?php foreach ($estados->results as $estado): ?>
                                            <option value="<?= $estado->sigla ?>"><?= $estado->nome ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-grp">
                                <label class="lbl-default">CEP</label>
                                <input type="text" class="form-control cep" name="cep">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-grp">
                                <label class="lbl-default">Complemento</label>
                                <input type="text" class="form-control" name="complemento">
                            </div>
                        </div>
                    </div>
                </div>

                <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                    <div class="form-grp">
                        <label class="lbl-default">Anexar Documentos</label>
                        <input type="file" class="form-control" name="documentos[]" multiple>
                    </div>
                </div>

            </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button id="send-btn">Enviar</button>
        </div>
    </form>
</div>