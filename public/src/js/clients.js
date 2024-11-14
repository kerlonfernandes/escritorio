$(document).ready(function () {
  var table = $("#dataTable").DataTable({
    processing: true, // Exibe uma animação de carregamento enquanto os dados são carregados
    serverSide: true, // Ativa a paginação no lado do servidor
    searching: false, // Permite a pesquisa no lado do cliente
    ordering: true, // Ativa a ordenação
    ajax: {
      url: "api/clientes_table.php", // Caminho para o arquivo PHP
      type: "GET",
      data: function (d) {
        var filterField = $("#filter").val();
        var searchTerm = $("#search").val();

        var orderColumn = d.order[0] ? d.columns[d.order[0].column].data : "id";
        var orderDir = d.order[0] ? d.order[0].dir : "asc";

        return $.extend({}, d, {
          start: d.start,
          length: d.length,
          draw: d.draw,
          filterField: filterField,
          searchTerm: searchTerm,
          orderColumn: orderColumn,
          orderDir: orderDir,
        });
      },
      error: function (xhr, error, thrown) {
        console.log("Erro de AJAX: ", error);
        console.log(xhr.responseText);
      },
    },
    columns: [
      {
        data: "id",
        render: function (data) {
          return (
            '<button class="action-button access" data-id="' +
            data +
            '">Acessar</button>' +
            '<button class="action-button delete" data-id="' +
            data +
            '">Deletar</button>'
          );
        },
      },
      {
        data: "id",
      },
      {
        data: "nome",
        render: function (data) {
          return (
            '<span class="copy-button" data-clipboard-text="' +
            data +
            '">' +
            data +
            "</span>"
          );
        },
      },
      {
        data: "cpf",
        render: function (data) {
          return (
            '<span class="copy-button" data-clipboard-text="' +
            data +
            '">' +
            data +
            "</span>"
          );
        },
      },
      {
        data: "telefone",
        render: function (data) {
          return (
            '<span class="copy-button" data-clipboard-text="' +
            data +
            '">' +
            data +
            "</span>"
          );
        },
      },
      {
        data: "situacao",
      },
    ],
    language: {
      sProcessing: "Processando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "Nenhum registro encontrado",
      sInfo: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
      sInfoEmpty: "Mostrando 0 até 0 de 0 registros",
      sInfoFiltered: "(filtrado de _MAX_ registros no total)",
      sSearch: "Pesquisar:",
      oPaginate: {
        sFirst: "Primeiro",
        sPrevious: "Anterior",
        sNext: "Próximo",
        sLast: "Último",
      },
    },
  });

  var clipboard = new ClipboardJS(".copy-button");

  clipboard.on("success", function (e) {
    alert("Valor copiado: " + e.text);
    e.clearSelection();
  });

  clipboard.on("error", function (e) {
    alert("Falha ao copiar!");
  });

  $("#dataTable").on("click", ".access", function () {
    var userId = $(this).data("id");
    window.location.href = "?page=cliente&id=" + userId;
  });
  $("#dataTable").on("click", ".delete", function () {
    var userId = $(this).data("id");

    Swal.fire({
      title: "Tem certeza que deseja deletar o cliente com ID: " + userId,
      text: "Esta ação não pode ser revertida!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sim, quero deletar!",
      cancelButtonText: "Não",
    }).then((result) => {
      if (result.isConfirmed) {

        $.ajax({
          url: "ajax/deletar_cliente.php",
          type: "POST",
          dataType: "json",
          data: {
            clienteId: userId,
          },
          success: function (response) {
            if (response.status === "success") {
              Swal.fire({
                title: response.title,
                text: response.message,
                icon: response.status
              });
              $("#dataTable")
                .DataTable()
                .row($(this).closest("tr"))
                .remove()
                .draw();
            } else {
              alert("Erro ao excluir o usuário. " + response.message);
            }
          },
          error: function (xhr, status, error) {
            alert("Houve um erro ao tentar excluir o usuário. Tente novamente.");
          },
        });

        
      }
    });
  });

  $("#search").on("keyup", function () {
    table.ajax.reload();
  });

});
