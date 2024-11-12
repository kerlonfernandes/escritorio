function toggleSidebar() {
  const sidebar = document.getElementById("sidebarMenu");
  const menuButton = document.querySelector(".menu-toggle");
  sidebar.classList.toggle("collapsed");

  if (sidebar.classList.contains("collapsed")) {
    menuButton.style.zIndex = "1060"; // Fica à frente da lateral quando a barra lateral está fechada
  } else {
    menuButton.style.zIndex = "-1"; // Fica atrás da lateral quando a barra lateral está aberta
  }
}

// Inicia a barra lateral com comportamento adequado conforme o tamanho da tela
document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.getElementById("sidebarMenu");
  const menuButton = document.querySelector(".menu-toggle");

  if (window.innerWidth >= 768) {
    sidebar.classList.remove("collapsed");
    menuButton.style.zIndex = "-1";
  } else {
    sidebar.classList.add("collapsed");
    menuButton.style.zIndex = "1060";
  }
});

window.addEventListener("resize", function () {
  const sidebar = document.getElementById("sidebarMenu");
  const menuButton = document.querySelector(".menu-toggle");
  if (window.innerWidth >= 768) {
    sidebar.classList.remove("collapsed");
    menuButton.style.zIndex = "-1";
  } else {
    sidebar.classList.add("collapsed"); // Barra lateral fechada em dispositivos móveis
    menuButton.style.zIndex = "1060"; // Fica à frente da lateral quando a barra lateral está fechada
  }
});

