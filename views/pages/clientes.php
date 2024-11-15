<div class="container">
    <div id="filter-container">
        <label for="filter">Pesquisar por:</label>
        <select id="filter">
            <option value="nome">Nome</option>
            <option value="cpf">CPF</option>
            <option value="telefone">Telefone</option>
            <option value="cidade">Cidade</option>

        </select>
        <input type="text" id="search" placeholder="Digite para pesquisar...">
    </div>
    <a href="<?= SITE ?>/?page=cadastrar-cliente" class="btn-sec no-link">
        Cadastrar Cliente
    </a>
    <table id="dataTable" class="display">
        <thead>
            <tr>
                <th>Ações</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Número</th>
                <th>Cidade</th>
                <th>Situação</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>