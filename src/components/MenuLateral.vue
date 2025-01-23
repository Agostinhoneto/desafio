<template>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="main-sidebar bg-dark text-white">
            <div class="brand-link text-center py-3">
                <h4>Sistema</h4>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <router-link to="/dashboard" class="nav-link text-white" aria-label="Ir para a página inicial">
                        <i class="fas fa-home"></i>
                        <span class="ml-2">Dashboard</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/receitas" class="nav-link text-white" aria-label="Ir para a página Receitas">
                        <i class="fas fa-wallet"></i> <span class="ml-2">Receitas</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/despesas" class="nav-link text-white" aria-label="Ir para a página Despesas">
                        <i class="fas fa-wallet"></i> <span class="ml-2">Despesas</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/financas" class="nav-link text-white" aria-label="Ir para a página Finanças">
                        <i class="fas fa-wallet"></i> <span class="ml-2">Minhas Finanças</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <a href="/relatorios" class="nav-link text-white">
                        <i class="fas fa-chart-line"></i> <span class="ml-2">Relatórios</span>
                    </a>
                </li>
                <li class="nav-item">
                    <router-link to="/lista-usuarios" class="nav-link text-white" aria-label="Ir para a página Usuários">
                        <i class="fas fa-user"></i> <span class="ml-2">Usuários</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/lista-configuracoes" class="nav-link text-white" aria-label="Ir para a página Configurações">
                        <i class="fas fa-cogs"></i> <span class="ml-2">Configurações</span>
                    </router-link>
                </li>
            </ul>
        </aside>
    </div>
</template>

<style>
.wrapper {
    display: flex;
    height: 100vh;
}

.main-sidebar {
    width: 250px;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #343a40;
    color: #fff;
    overflow-y: auto;
}

.main-sidebar .brand-link {
    background: #212529;
    font-size: 1.5rem;
    font-weight: bold;
}

.nav-item {
    padding: 10px 20px;
}

.nav-link {
    color: #ddd;
    font-size: 1rem;
    display: flex;
    align-items: center;
    text-decoration: none;
}

.nav-link:hover {
    background-color: #495057;
    color: #fff;
    border-radius: 4px;
}

.content-wrapper {
    margin-left: 250px;
    /* Same width as sidebar */
    flex: 1;
    display: flex;
    flex-direction: column;
    background-color: #f8f9fa;
}

header {
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
</style>