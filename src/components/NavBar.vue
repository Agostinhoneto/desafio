<template>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#"><h2>Controle de Gastos</h2></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <router-link to="/" class="nav-link" aria-label="Ir para a página inicial">Home</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/dashboard" class="nav-link" aria-label="Ir para o dashboard">Dashboard</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/usuarios" class="nav-link" aria-label="Cadastrar usuários">Usuários</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/receitas" class="nav-link" aria-label="Cadastrar receitas">Receitas</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/despesas" class="nav-link" aria-label="Cadastrar despesas">Despesas</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/enderecos" class="nav-link" aria-label="Cadastrar endereços">Endereços</router-link>
                </li>
            </ul>
        </div>
    </div>
</nav>

</template>

<script>
export default {

}
</script>

<style></style>