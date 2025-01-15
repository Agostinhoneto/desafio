<template>
    <br>
    <h2>Lista de Usuários</h2>
    <hr> 
    <div>
        <router-link :to="{ name: 'cad-usuarios'}">
            <button type="submit" class="btn btn-success">Novo</button>
        </router-link>
    </div>
    <div
      class="mt-3"
      striped
      hover
      :users="users"
    >
    </div>
    <br>
    <form>
        <div class="form-group col-4">
            <br>
            <label for="nome">Digte : Nome Email ou CPF </label>
            <input type="text" class="form-control" id="name" v-model="search" placeholder="Digite o nome"/>
        </div>    
        <br>
        <div class="form-group col-md-2">
            <label for="date">Data de Cadastro:</label>
            <input type="date" class="form-control" id="date" >
        </div> 
        <br>
        <div class="form-group col-md-2">
            <label for="date">Data Fim:</label>
            <input type="date" class="form-control" id="date">
        </div>
        <br>
    </form>   
    <br>
    
    <h3>Lista de Usuários</h3>
    <hr>
    
    <table  class="table">
        <thead >
            <tr>
            <th >#</th>
            <th >Data de Cadastro</th>
            <th >Nome</th>
            <th >Email</th>
            <th >CPF</th>
            <th >Perfil</th>
            <th >Ações</th>
            </tr>
        </thead>
        
        <tbody  v-for="user in filterUser"
            :key="user.id">
            <tr>
                <td >{{user.id }}</td>
                <td>{{ moment(user.created_at)}}</td>
                <td >{{user.name }}</td>
                <td>{{user.email }}</td>
                <td>{{user.cpf }}</td>
                <td>{{ user.role.name }}</td>
                <td>
                    |  
                    <router-link
                        :to="{ name: 'user-todo', params: { id: user.id }}"
                    >
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-light">Detalhar</button>
                        </div> 
                    </router-link>
                    |   
                    <router-link
                        :to="{ name: 'cad-usuarios', params: { id: user.id }}"
                    >
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary">Editar</button>
                        </div>   
                    </router-link>
                    |  
                    <small>
                        <a
                            href=""
                            class="text-danger"
                            @click.stop.prevent="remover(user.id)"
                        >
                        <button type="button" class="btn btn-danger"> Delete</button>
                        </a>
                    </small>  
                </td>  
            </tr>         
        </tbody>
    </table>
</template>

<script>
    export default {
        data(){
            return {
                search:"",
                searchEmail:"",
                users:"",
                users:[
                ],
            };
        },
        filters: {
            moment: function (date) {
                console.log(date);
                return moment(date).format('DD/MM/YYYY, h:mm:ss a');
            }
        },
        computed:{ 
             
            filterUser(){
                let users = [];
                users = this.users.filter((user) => {
                    return (
                    user.name.toLowerCase().indexOf(this.search.toLowerCase()) > -1 ||
                    user.cpf.indexOf(this.search) > -1 ||
                    user.email.indexOf(this.search) > -1 
                        
                    );
                });   
                return users;
            },
            formatarData(){
                let data = this.user.created_at
                this.user.created_at = moment(data).format('DD/MM/YYYY')

            }  
        },
       async mounted(){
            await this.listarTodos();
          const id = this.$route.params.id;
          fetch(`http://127.0.0.1:8000/api/show/${id}`)
          .then(response => response.json())
          .then(res => this.user = res.data);
        },
        
      methods: 
        {   
            moment: function (date) {

                let data = new Date();
                let dataFormatada = ((data.getDate() )) + "/" + ((data.getMonth() + 1)) + "/" + data.getFullYear(); 
                console.log(dataFormatada);
                return dataFormatada;
            },

           async listarTodos(){
               await fetch('http://127.0.0.1:8000/api/index').then(response=> response.json())
                    .then((res) =>{
                        this.users = res.data;
                });
            },

            async remover(userId) {
                await fetch(`http://127.0.0.1:8000/api/destroy/${userId}`,
                {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                })
                .then(() => {
                    const todos = this.user;
                });             
                await this.listarTodos();
                alert('Dados excluidos com Sucesso');
            },
        },
    }
</script>
   



