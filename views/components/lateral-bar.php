<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
    <button class="close-btn mb-2" onclick="toggleSidebar()">✕</button>

    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= ($current_page == 'home') ? 'active' : '' ?>" href="?page=home">Início</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($current_page == 'clientes') ? 'active' : '' ?>" href="?page=clientes">Clientes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($current_page == 'cadastrar-cliente') ? 'active' : '' ?>" href="?page=cadastrar-cliente">Cadastrar clientes</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link <?= ($current_page == 'configuracoes') ? 'active' : '' ?>" href="?page=configuracoes">Configurações</a>
            </li> -->
        </ul>
    </div>
</nav>