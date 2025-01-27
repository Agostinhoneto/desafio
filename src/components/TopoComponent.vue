<template>
    <header class="bg-primary text-white py-3 shadow">
      <div class="container d-flex justify-content-between align-items-center">
        <h1 class="h4">Controle de Gastos</h1>
        <nav>
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link text-white" href="/dashboard">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="/reports">Relatórios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="/logout">
                <i class="fas fa-sign-out-alt"></i> Sair
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </header>
  </template>
  
  <script>
  export default {
    name: "TopoComponent",
  };
  </script>
  
  <style scoped>
  header {
    background-color: #007bff;
  }
  .nav-link:hover {
    text-decoration: underline;
  }
  </style>
  