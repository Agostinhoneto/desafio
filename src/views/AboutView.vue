<template>
  <div class="container">
    <br>
    <div>
      <router-link :to="{ name: 'home' }">
        <button type="submit" class="btn btn-success">Voltar</button>
      </router-link>
    </div>
    <div class="container pt-5">
      <h1>Detalhes do Usuário</h1>
      <p></p>
      <p></p>
      <div class="about">
        <br>
        <div class="d-flex justify-content-between">
          <div class="alert alert-success" role="alert">
            <h1 class="alert-heading">Nome : {{ user.name }}</h1>
            <p>
            <h1>Email : {{ user.email }}</h1>
            </p>
            <hr>
            <p class="mb-0">
            <h1>CPF : {{ user.cpf }}</h1>
            </p>
          </div>
          <div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      user: {},
    };
  },
  mounted() {
    const id = this.$route.params.id;
    fetch(`http://127.0.0.1:8000/api/show/${id}`)
      .then(response => response.json())
      .then(res => this.user = res.data);
  },
};       
</script>

<style></style>
