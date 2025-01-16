<template>
    <form @submit.prevent>
      <div class="form-group col-4">
        <label for="search">Digite: Nome, Email ou CPF</label>
        <input
          type="text"
          class="form-control"
          id="search"
          v-model="search"
          placeholder="Digite o nome"
          @input="$emit('input', search)"
        />
      </div>
    </form>
  </template>
  
  <script>
  export default {
    data() {
      return {
        search: '',
      };
    },
  };
  </script>
  
  <style scoped>
  .form-group {
    margin-bottom: 20px;
  }
  </style>
  