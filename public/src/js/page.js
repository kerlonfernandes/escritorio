window.addEventListener("load", function () {
  const overlay = document.getElementById("loadingOverlay");
  overlay.classList.add("hidden");
  document.body.classList.remove("no-scroll");

  const collapseElement = document.getElementById("collapseExample");
  if (collapseElement) {
    setTimeout(function () {
      collapseElement.classList.add("show");
    }, 100);
  }
});
