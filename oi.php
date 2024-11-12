<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Step Form</title>

    <!-- Smart Wizard CSS -->
    <link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Smart Wizard JS -->
    <script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-section {
            margin-bottom: 20px;
        }

        .nav-link {
            background: none !important;

        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h2 class="sec-title">Cadastro do Cliente</h2>
        <form id="client-form">
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
                    <!-- Step 1: Informações do Cliente -->
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
                                    <input type="date" class="form-control" name="data_nascimento" id="data_nascimento" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-grp">
                                    <label class="lbl-default">Idade</label>
                                    <input type="number" class="form-control" name="idade" id="idade" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-grp">
                                    <label class="lbl-default">Gênero</label>
                                    <select class="form-select" name="genero">
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
                    </div>

                    <!-- Step 2: Informações de Contato -->
                    <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-grp">
                                    <label class="lbl-default">Telefone</label>
                                    <input type="tel" class="form-control" name="telefone">
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
                                        <option value="">Selecione</option>
                                        <option value="SP">SP</option>
                                        <option value="RJ">RJ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-grp">
                                    <label class="lbl-default">CEP</label>
                                    <input type="text" class="form-control" name="cep">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Documentos -->
                    <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                        <div class="form-grp">
                            <label class="lbl-default">Anexar Documentos</label>
                            <input type="file" class="form-control" name="documentos" multiple>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botão de Submissão -->
            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-primary cadastrar-btn">Cadastrar Cliente</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Smart Wizard
            $('#smartwizard').smartWizard({
                theme: 'dots',
                transitionEffect: 'fade',
                toolbarSettings: {
                    toolbarPosition: 'bottom'
                },
                enableProgress: true,
                transitionSpeed: '400'
            });

            // Function to add additional fields
            window.addField = function(type) {
                var fieldHTML = '<div class="form-section"><input type="text" class="form-control" name="' + type + '[]"><button type="button" onclick="removeField(this)">Remover</button></div>';
                $('#' + type + '-extra').append(fieldHTML);
            }

            window.removeField = function(element) {
                $(element).closest('.form-section').remove();
            }

            // Copy button functionality
            $('#copy-button').click(function() {
                var formData = $('#client-form').serializeArray();
                var dataText = formData.map(item => `${item.name}: ${item.value}`).join('\n');
                navigator.clipboard.writeText(dataText).then(() => alert('Informações copiadas!'));
            });
        });

        // Suponha que você tenha os dados do cliente em um objeto JavaScript
        var cliente = {
            nome_completo: "João Silva",
            data_nascimento: "1985-10-25",
            idade: 39,
            genero: "masculino",
            estado_civil: "casado",
            telefone: "(11) 98765-4321",
            email: "joao.silva@email.com",
            rua: "Rua das Flores",
            numero: "123",
            bairro: "Centro",
            cidade: "São Paulo",
            uf: "SP",
            cep: "01001-000"
        };

        // Preenchendo os campos com as informações
        $(document).ready(function() {
            $("input[name='nome_completo']").val(cliente.nome_completo);
            $("input[name='data_nascimento']").val(cliente.data_nascimento);
            $("input[name='idade']").val(cliente.idade);
            $("select[name='genero']").val(cliente.genero);
            $("select[name='estado_civil']").val(cliente.estado_civil);
            $("input[name='telefone']").val(cliente.telefone);
            $("input[name='email']").val(cliente.email);
            $("input[name='rua']").val(cliente.rua);
            $("input[name='numero']").val(cliente.numero);
            $("input[name='bairro']").val(cliente.bairro);
            $("input[name='cidade']").val(cliente.cidade);
            $("select[name='uf']").val(cliente.uf);
            $("input[name='cep']").val(cliente.cep);
        });

        function calcularIdade(dataNascimento) {
            var hoje = new Date();
            var nascimento = new Date(dataNascimento);
            var idade = hoje.getFullYear() - nascimento.getFullYear();
            var mes = hoje.getMonth() - nascimento.getMonth();
            if (mes < 0 || (mes === 0 && hoje.getDate() < nascimento.getDate())) {
                idade--;
            }
            return idade;
        }
        $('#data_nascimento').on('change', function() {
            var dataNascimento = $(this).val();

            var dataMinima = new Date();
            dataMinima.setFullYear(dataMinima.getFullYear() - 120);
            if (new Date(dataNascimento) > dataMinima) {
                var idade = calcularIdade(dataNascimento);
                $('#idade').val(idade);
            } else {
                // Se a data for menor ou igual a data mínima, não calcula a idade
                $('#idade').val('');
            }
        });
    </script>

</body>

</html>