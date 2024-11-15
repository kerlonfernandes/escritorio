$(document).on("click", ".deletar-arquivo", function (e) {
  let id = $(this).attr("data-id");
  let arquivo = $(this).attr("data-file");
  if (id) {
    createYesNoDialog(
      `<strong>Tem certeza que deseja deletar o arquivo</strong> <i>${arquivo}</i>?`,
      () => {
        $.ajax({
          url: "ajax/deleta_arquivo.php",
          type: "POST",
          dataType: "json",
          data: {
            id: id,
          },
          success: function (response) {
            Swal.fire({
              title: response.title,
              text: response.message,
              icon: response.status,
            });
          },
          error: function (xhr, status, error) {
            Swal.fire({
              title: "Ocorreu um erro",
              text: "Ocorreu um erro ao executar esta ação.",
              icon: "error",
            });
          },
        });
      }
    );
  }
});

function toggleEdit() {
  const form = document.getElementById("userForm");
  const inputs = form.querySelectorAll("input, textarea, select");
  const toggleButton = document.getElementById("toggleEditButton");

  if (toggleButton.innerText === "Editar") {
    inputs.forEach((input) => {
      if (input.type !== "hidden") {
        if (input.tagName === "SELECT") {
          input.disabled = false;
        } else {
          input.readOnly = false;
        }
      }
    });
    toggleButton.innerText = "Salvar";
  } else {

    const formData = new FormData(form);
    $.ajax({
      url: "ajax/editar_cliente.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        Swal.fire({
            title: response.title,
            text: response.message,
            icon: response.status,
          });
        inputs.forEach((input) => {
          if (input.tagName === "SELECT") {
            input.disabled = true;
          } else {
            input.readOnly = true;
          }
        });
        toggleButton.innerText = "Editar";
      },
      error: function (error) {
        alert("Erro ao salvar dados!");
      },
    });
  }
}

$(document).on("keyup", ".cep", function () {
    let cep = $(this).val().replace(/\D/g, "");

    if (cep != "" && cep.length == 8) {
      $.ajax({
        url: "https://viacep.com.br/ws/" + cep + "/json/",
        dataType: "json",
        type: "GET",
        success: function (data) {
          if (!("erro" in data)) {
            $("#logradouro").val(data.logradouro);
            $("#bairro").val(data.bairro);
            $("#cidade").val(data.localidade);
            $("#estado").val(data.uf);
          } else {
            alert("CEP não encontrado.");
          }
        },
        error: function () {
          alert("Erro ao buscar CEP. Por favor, tente novamente mais tarde.");
        },
      });
    } else {
      //   alert("Formato de CEP inválido.");
    }
  });