class Page {
  static hideOverlay() {
    $("#overlay").fadeOut("slow", function () {});
  }
  static showOverlay() {
    $("#overlay").fadeIn(1000).delay(3000);
  }
}

function showToast(type = "success", message = "", duration = 3000) {
  let bodyPage = document.body;

  let toastContainer = document.createElement("div");
  toastContainer.className = "toast-container position-fixed top-0 end-0 p-6";

  let toastHTML = "";
  if (type === "error") {
    toastHTML = `
            <div class="toast bg-danger" role="alert" aria-live="assertive" aria-atomic="true" style="color:white;" data-delay="${duration}">
                <div class="toast-body">
                    <div class="d-flex gap-4">
                        <span><i class="fa-solid fa-circle-xmark fa-lg icon-error"></i></span>
                        <div class="d-flex flex-column flex-grow-1 gap-2">
                            <div class="d-flex align-items-center">
                                <span class="fw-semibold">Ocorreu um erro!</span>
                                <button type="button" class="btn-close btn-close-sm ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <span>${message}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
  } else if (type === "success") {
    toastHTML = `
            <div class="toast bg-success" role="alert" aria-live="assertive" aria-atomic="true" style="color:white;" data-delay="${duration}">
                <div class="toast-body">
                    <div class="d-flex gap-4">
                        <span><i class="fa-solid fa-circle-check fa-lg icon-success"></i></span>
                        <div class="d-flex flex-column flex-grow-1 gap-2">
                            <div class="d-flex align-items-center">
                                <span class="fw-semibold">Sucesso!</span>
                                <button type="button" class="btn-close btn-close-sm ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <span>${message}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
  } else {
    // Tipo desconhecido
    console.error("Tipo de toast desconhecido:", type);
    return;
  }

  toastContainer.innerHTML = toastHTML;

  bodyPage.appendChild(toastContainer);

  let toastLiveExample = toastContainer.querySelector(".toast");
  let toast = new bootstrap.Toast(toastLiveExample);
  toast.show();
}

function criarCaixaDialogo(
  textoPergunta,
  textoCancelar,
  textoDeletar,
  funcaoDeletar
) {
  var overlay = document.createElement("div");
  overlay.classList.add("overlay");
  overlay.id = "overlay";

  var confirmationBox = document.createElement("div");
  confirmationBox.classList.add("confirmation-box");
  confirmationBox.id = "confirmationBox";

  var paragrafo = document.createElement("p");
  paragrafo.textContent = textoPergunta;
  confirmationBox.appendChild(paragrafo);

  var botaoCancelar = document.createElement("button");
  botaoCancelar.classList.add("cancel-button");
  botaoCancelar.textContent = textoCancelar;
  botaoCancelar.onclick = function () {
    fecharOverlay();
  };
  confirmationBox.appendChild(botaoCancelar);

  var botaoDeletar = document.createElement("button");
  botaoDeletar.classList.add("delete-button");
  botaoDeletar.textContent = textoDeletar;
  botaoDeletar.onclick = function () {
    if (typeof funcaoDeletar === "function") {
      funcaoDeletar();
      fecharOverlay();
    }
  };
  confirmationBox.appendChild(botaoDeletar);

  overlay.appendChild(confirmationBox);

  document.body.appendChild(overlay);

  abrirOverlay();
}

function abrirOverlay() {
  var overlay = document.getElementById("overlay");
  var confirmationBox = document.getElementById("confirmationBox");

  overlay.style.display = "flex";
  setTimeout(function () {
    overlay.classList.add("active");
    confirmationBox.classList.add("active");
  }, 10);
}

function fecharOverlay() {
  var overlay = document.getElementById("overlay");
  var confirmationBox = document.getElementById("confirmationBox");

  overlay.classList.remove("active");
  confirmationBox.classList.remove("active");

  setTimeout(function () {
    overlay.style.display = "none";
    // Remover a caixa de diálogo após fechar
    document.body.removeChild(overlay);
  }, 300);
}

function confirmarDelecao() {
  alert("Item deletado com sucesso!");
}

function createYesNoDialog(message, yesCallback, noCallback) {
  $("#yesNoModal").remove();

  var dialog = document.createElement("div");
  dialog.className = "modal fade";
  dialog.id = "yesNoModal";
  dialog.setAttribute("tabindex", "-1");
  dialog.setAttribute("aria-labelledby", "yesNoModalLabel");
  dialog.setAttribute("aria-hidden", "true");

  dialog.innerHTML = `
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:2px;">
      <div class="modal-header">
        <h5 class="modal-title" id="yesNoModalLabel">Confirmação</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>${message}</p>
      </div>
      <div class="modal-footer">
        <div class="container">
          <div class="row">
            <div class="col-6 d-flex justify-content-start">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
            </div>
            <div class="col-6 d-flex justify-content-end">
              <button type="button" class="btn btn-primary">Sim</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
`;

  document.body.appendChild(dialog);

  $("#yesNoModal").modal("show");

  dialog.querySelector(".btn-primary").addEventListener("click", handleYes);

  function handleYes() {
    $("#yesNoModal").modal("hide");
    if (typeof yesCallback === "function") {
      yesCallback();
    }
  }

  dialog.querySelector(".btn-secondary").addEventListener("click", function () {
    $("#yesNoModal").modal("hide");
    if (typeof noCallback === "function") {
      noCallback();
    }
  });
}

function createInputDialog(
  message,
  inputType,
  confirmCallback,
  title = "Confirmação",
  inputPlaceholder = "",
  initialValue = "",
  inputId = "inputField"
) {
  $("#inputModal").remove();

  var dialog = document.createElement("div");
  dialog.className = "modal fade";
  dialog.id = "inputModal";
  dialog.setAttribute("tabindex", "-1");
  dialog.setAttribute("aria-labelledby", "inputModalLabel");
  dialog.setAttribute("aria-hidden", "true");

  dialog.innerHTML = `
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:2px;">
          <div class="modal-header">
            <h5 class="modal-title" id="inputModalLabel">${title}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>${message}</p>
            <input type="${inputType}" class="form-control" id="${inputId}" placeholder="${inputPlaceholder}" value="${initialValue}">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary sys-btn" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary sys-btn" id="confirmButton">Confirmar</button>
          </div>
        </div>
      </div>
    `;

  document.body.appendChild(dialog);

  $("#inputModal").modal("show");

  dialog.querySelector("#confirmButton").addEventListener("click", function () {
    var inputValue = dialog.querySelector(`#${inputId}`).value;
    $("#inputModal").modal("hide");
    if (typeof confirmCallback === "function") {
      confirmCallback(inputValue);
    }
  });
}

function validatePassword(password) {
  let errors = [];

  // Validação para cada critério
  if (password.length < 8) {
    $("#min-length").removeClass("text-success").addClass("text-danger");
  } else {
    $("#min-length").removeClass("text-danger").addClass("text-success");
  }

  if (!/[A-Z]/.test(password)) {
    $("#uppercase").removeClass("text-success").addClass("text-danger");
  } else {
    $("#uppercase").removeClass("text-danger").addClass("text-success");
  }

  if (!/[a-z]/.test(password)) {
    $("#lowercase").removeClass("text-success").addClass("text-danger");
  } else {
    $("#lowercase").removeClass("text-danger").addClass("text-success");
  }

  if (!/[0-9]/.test(password)) {
    $("#number").removeClass("text-success").addClass("text-danger");
  } else {
    $("#number").removeClass("text-danger").addClass("text-success");
  }

  if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
    $("#special-char").removeClass("text-success").addClass("text-danger");
  } else {
    $("#special-char").removeClass("text-danger").addClass("text-success");
  }

  // Retorna os erros encontrados
  return errors;
}
