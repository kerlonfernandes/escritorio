$(document).ready(function () {
  var clienteId = 123;

  $.ajax({
    url: "/cliente/" + clienteId,
    method: "GET",
    success: function (response) {
      // Preenche os campos com os dados recebidos
      $("input[name='nome_completo']").val(response.nome_completo);
      $("input[name='data_nascimento']").val(response.data_nascimento);
      $("input[name='idade']").val(response.idade);
      $("select[name='genero']").val(response.genero);
      $("select[name='estado_civil']").val(response.estado_civil);
      $("input[name='telefone']").val(response.telefone);
      $("input[name='email']").val(response.email);
      $("input[name='rua']").val(response.rua);
      $("input[name='numero']").val(response.numero);
      $("input[name='bairro']").val(response.bairro);
      $("input[name='cidade']").val(response.cidade);
      $("select[name='uf']").val(response.uf);
      $("input[name='cep']").val(response.cep);
    },
    error: function (err) {
      console.error("Erro ao carregar os dados do cliente", err);
    },
  });
});

// $(document).ready(function () {
//   // Inicialize o SmartWizard
//   $("#smartwizard").smartWizard({
//     // Opções do SmartWizard
//     selected: 0, // Começa pelo primeiro passo
//     theme: "dots", // Use o tema 'dots'
//     transition: {
//       animation: "fade", // Animação entre os passos
//       speed: "300", // Velocidade da transição
//       easing: "ease",
//     },
//   });

//   // Suponha que os dados do cliente sejam carregados de alguma forma (AJAX ou variável)
//   var cliente = {
//     nome_completo: "João Silva",
//     data_nascimento: "1985-10-25",
//     idade: 39,
//     genero: "masculino",
//     estado_civil: "casado",
//     telefone: "(11) 98765-4321",
//     email: "joao.silva@email.com",
//     rua: "Rua das Flores",
//     numero: "123",
//     bairro: "Centro",
//     cidade: "São Paulo",
//     uf: "SP",
//     cep: "01001-000",
//   };

//   // Função que preenche os dados no formulário
//   function preencherFormulario(cliente) {
//     $("input[name='nome_completo']").val(cliente.nome_completo);
//     $("input[name='data_nascimento']").val(cliente.data_nascimento);
//     $("input[name='idade']").val(cliente.idade);
//     $("select[name='genero']").val(cliente.genero);
//     $("select[name='estado_civil']").val(cliente.estado_civil);
//     $("input[name='telefone']").val(cliente.telefone);
//     $("input[name='email']").val(cliente.email);
//     $("input[name='rua']").val(cliente.rua);
//     $("input[name='numero']").val(cliente.numero);
//     $("input[name='bairro']").val(cliente.bairro);
//     $("input[name='cidade']").val(cliente.cidade);
//     $("select[name='uf']").val(cliente.uf);
//     $("input[name='cep']").val(cliente.cep);
//   }

//   // Chame a função para preencher o formulário
//   preencherFormulario(cliente);

//   // Libera os steps e navega até o próximo passo (por exemplo, para o passo 2)
//   $("#smartwizard").smartWizard("goToStep", 1); // Vai para o segundo passo

//   // Habilita todos os steps
//   $("#smartwizard").smartWizard("enable"); // Libera a navegação entre os steps
// });
