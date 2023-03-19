
<template>
    <h2>Lista de Usuários</h2>
    <button type="submit" class="btn btn-primary">Novo</button>
    <br>
    <form>
        <br><br>
        <div class="form-group col-md-6">
            <label for="nome">Nome</label>
            <br>
            <input type="nome" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Nome">
        </div>
        <br>
        <div class="form-group col-md-6">
            <label for="cpf">CPF</label>
            <input type="password" class="form-control" id="cpf" placeholder="CPF">
        </div>
        <br>
        <div class="form-group col-md-2">
            <label for="date">Data Inicio</label>
            <input type="password" class="form-control" id="date" placeholder="Inicio">
        </div> 
        <br>
        <div class="form-group col-md-2">
            <label for="date">Data Fim</label>
            <input type="password" class="form-control" id="date" placeholder="Fim">
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>
    <br><br>
    <table class="table">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Logradouro</th>
            <th>CEP</th>
            <th>Ação</th>
        </tr>
    </thead>

    <tbody>
        <tr>
        
        </tr>
    </tbody>
    </table>
  <div> 
      <div
          v-for="user in users"
          :key="user.id"
          class="card m-3"
      >
          <div class="card-body">
              <router-link
                :to="{ name: 'cad-usuarios', params: { id: user.id }}"
              >
              <button
                    type="button"
                    class="btn btn-primary"
                >
                    Update
                </button>
            </router-link>
     
                  {{ user.id }} // {{ user.created_at }} //{{ user.name }} //{{ user.cpf }} //{{ user.email }}//{{user.role.name }} 
              <div class="mt-2">
            </div>
          </div>
      </div>
  </div>
</template>
<script>
    export default {
        data(){
            return {
                users:[],
            };
        }, 
        mounted(){
            fetch('http://127.0.0.1:8000/api/index').then(response=> response.json())
            .then((res) =>{
                this.users = res.data;
            });
        },
    }
</script>
   



