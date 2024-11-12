document.addEventListener("DOMContentLoaded", function () {
  // Inicializa o SmartWizard
  $("#smartwizard").smartWizard({
    theme: "dots", // Tema do SmartWizard
    transitionEffect: "slide", // Efeito de transição
    transitionDirection: "horizontal", // Direção da transição
    toolbarSettings: {
      toolbarPosition: "bottom", // A posição da barra de ferramentas
    },
    enableProgress: true, // Habilita o progresso de etapas
    transitionSpeed: "400", // Velocidade da transição
    lang: {
      next: "Próximo", // Texto para o botão de próximo
      previous: "Anterior", // Texto para o botão de anterior
      finish: "Finalizar", // Texto para o botão de finalizar
    },
  });

  // Evento de clique para o botão de envio
  $("#send-btn").on("click", function (e) {
    e.preventDefault(); // Impede o envio padrão do formulário

    let valid = true;

    // Validação de campos obrigatórios em cada etapa do formulário
    $("#client-form .tab-pane").each(function (index, tab) {
      $(tab)
        .find("input[required], select[required]")
        .each(function () {
          if (!$(this).val()) {
            valid = false; // Marca como inválido se algum campo obrigatório não for preenchido
            $("#smartwizard").smartWizard("goToStep", index + 1); // Vai para a etapa onde o erro ocorreu
            return false;
          }
        });
      if (!valid) return false; // Para a execução se algum campo estiver faltando
    });

    // Se o formulário for válido, envia os dados via AJAX
    if (valid) {
      var formData = new FormData($("#client-form")[0]); // Cria um FormData para manipulação dos dados do formulário

      $.ajax({
        url: "ajax/cadastrar_cliente.php", // URL de destino
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          var res = JSON.parse(response);
          if (res.status === "success") {
            alert(res.message); // Exibe a mensagem de sucesso
            $("#client-form")[0].reset(); // Limpa o formulário
            $("#smartwizard").smartWizard("reset"); // Reseta o SmartWizard
          } else {
            alert("Erro: " + res.message); // Exibe a mensagem de erro
          }
        },
        error: function () {
          alert("Ocorreu um erro ao enviar o formulário.");
        },
      });
    } else {
      alert("Por favor, preencha todos os campos obrigatórios.");
    }
  });

  // Função para adicionar campos extras ao formulário
  window.addField = function (type) {
    var fieldHTML =
      '<div class="form-section"><input type="text" class="form-control" name="' +
      type +
      '[]"><button type="button" onclick="removeField(this)">Remover</button></div>';
    $("#" + type + "-extra").append(fieldHTML);
  };

  // Função para remover campos extras do formulário
  window.removeField = function (element) {
    $(element).closest(".form-section").remove();
  };

  // Função para copiar os dados do formulário para a área de transferência
  $("#copy-button").click(function () {
    var formData = $("#client-form").serializeArray();
    var dataText = formData
      .map((item) => `${item.name}: ${item.value}`)
      .join("\n");
    navigator.clipboard
      .writeText(dataText)
      .then(() => alert("Informações copiadas!"));
  });

  // Função para calcular a idade a partir da data de nascimento
  function calcularIdade(dataNascimento) {
    var hoje = new Date();
    var nascimento = new Date(dataNascimento);
    var idade = hoje.getFullYear() - nascimento.getFullYear();
    var mes = hoje.getMonth() - nascimento.getMonth();
    if (mes < 0 || (mes === 0 && hoje.getDate() < nascimento.getDate())) {
      idade--; // Ajuste se o aniversário ainda não aconteceu neste ano
    }
    return idade;
  }

  $("#data_nascimento").on("change", function () {
    var dataNascimento = $(this).val();

    var dataMinima = new Date();
    dataMinima.setFullYear(dataMinima.getFullYear() - 120); // Limita a data mínima para 120 anos atrás
    if (new Date(dataNascimento) > dataMinima) {
      var idade = calcularIdade(dataNascimento);
      $("#idade").val(idade); // Exibe a idade calculada
    } else {
      $("#idade").val(""); // Limpa o campo de idade se a data for inválida
    }
  });
});
