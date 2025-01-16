<template>
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Data de Cadastro</th>
          <th>Nome</th>
          <th>Email</th>
          <th>CPF</th>
          <th>Perfil</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ formatDate(user.created_at) }}</td>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.cpf }}</td>
          <td>{{ user.role.name }}</td>
          <td>
            <router-link :to="{ name: 'user-todo', params: { id: user.id } }">
              <button type="button" class="btn btn-light">Detalhar</button>
            </router-link>
            <router-link :to="{ name: 'cad-usuarios', params: { id: user.id } }">
              <button type="button" class="btn btn-primary">Editar</button>
            </router-link>
            <button type="button" class="btn btn-danger" @click="remove(user.id)">
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </template>
  
  <script>
  export default {
    props: ['users'],
    methods: {
      formatDate(date) {
        return moment(date).format('DD/MM/YYYY, h:mm:ss a');
      },
      remove(id) {
        this.$emit('remove', id);
      },
    },
  };
  </script>
  
  <style scoped>
  .table th,
  .table td {
    vertical-align: middle;
  }
  </style>
  
  