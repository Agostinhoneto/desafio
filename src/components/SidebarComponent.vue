<template>
    <aside class="sidebar bg-light border-end h-100 position-fixed">
      <div class="sidebar-header p-3">
        <h4 class="text-primary">Menu</h4>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <a class="text-decoration-none" href="/dashboard">
            <i class="fas fa-tachometer-alt"></i> Dashboard
          </a>
        </li>
        <li class="list-group-item">
          <a class="text-decoration-none" href="/reports">
            <i class="fas fa-file-alt"></i> Relatórios
          </a>
        </li>
        <li class="list-group-item">
          <a class="text-decoration-none" href="/categories">
            <i class="fas fa-folder"></i> Categorias
          </a>
        </li>
        <li class="list-group-item">
          <a class="text-decoration-none" href="/expenses">
            <i class="fas fa-money-bill-wave"></i> Despesas
          </a>
        </li>
        <li class="list-group-item">
          <a class="text-decoration-none" href="/settings">
            <i class="fas fa-cog"></i> Configurações
          </a>
        </li>
      </ul>
    </aside>
  </template>
  
  <script>
  export default {
    name: "SidebarComponent",
  };
  </script>
  
  <style scoped>
  .sidebar {
    width: 250px;
  }
  .sidebar-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #ddd;
  }
  .list-group-item {
    border: none;
  }
  .list-group-item a {
    color: #333;
    display: flex;
    align-items: center;
  }
  .list-group-item a i {
    margin-right: 10px;
  }
  .list-group-item a:hover {
    color: #007bff;
  }
  </style>
  