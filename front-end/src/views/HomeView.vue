
<template>
    <h2>Lista de Usuários</h2>
    <button type="submit" class="btn btn-primary">Novo</button>
    <br>
    <form>
        <br><br>
        <div class="form-group col-md-6">
            <label for="exampleInputEmail1">Nome</label>
            <br>
            <input type="nome" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nome">
        </div>
        <br>
        <div class="form-group col-md-6">
            <label for="exampleInputPassword1">CPF</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="CPF">
        </div>
        <br>
        <div class="form-group col-md-2">
            <label for="exampleInputPassword1">Data Inicio</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Inicio">
        </div> 
        <br>
        <div class="form-group col-md-2">
            <label for="exampleInputPassword1">Data Fim</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Fim">
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
        <th scope="row">1</th>
        <td>Mark</td>
        <td>Otto</td>
        <td>@mdo</td>
        </tr>
        <tr>
        <th scope="row">2</th>
        <td>Jacob</td>
        <td>Thornton</td>
        <td>@fat</td>
        </tr>
        <tr>
        <th scope="row">3</th>
        <td>Larry</td>
        <td>the Bird</td>
        <td>@twitter</td>
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
                :to="{ name: 'user-todo', params: { id: user.id }}"
              >
                {{ user.name }} //{{ user.email }}
              </router-link>
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
             //   this.users = res.data.data
            });
        },
    }
</script>
   



