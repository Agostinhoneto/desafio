<template>
<br>
<div>
    <h2>Cadastrar Usuários</h2>
    <hr> 
    <div class="row">
        <form>
        <br><br>
        <div class="form-group col-md-6">
            <label for="exampleInputEmail1">Nome</label>
            <input type="nome" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nome">
        </div>
        <br>
        <div class="form-group col-md-6">
            <label for="exampleInputPassword1">CPF</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="CPF">
        </div>
        <br>
        <div class="form-group col-md-6">
            <label for="exampleInputPassword1">Email</label>
            <br>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Email">
        </div>
        <br>
        <div class="form-group col-md-6">
            <label for="exampleInputPassword1">Perfil</label>
            <br>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Perfil">
        </div>
        <br>
        <div class="form-group col-md-6">
            <label for="exampleInputPassword1">Logradouro</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Logradouro">
        </div>
        <br>
        <div class="form-group col-md-2">
            <label for="exampleInputPassword1">Cep</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Cep">
        </div> 
        <br>
        <button type="submit" class="btn btn-primary">Adcionar</button>
    </form>
    </div>     
    <br><hr>     
    <div class="col-md-9">
        <table class="table">
            <tbody>
                <tr>
                    <td>
                        <div v-for="user in users" :key="user.id">    
                            <hr>
                            <div>Usuarios:</div>
                            <hr>
                            <div class="card-body">
                                <td>{{ user.name }}</td>
                            </div>
                            
                            <div class="card-body">
                                <td>{{ user.email }}</td>
                            </div>
                            <div class="card-body">
                                <td>{{ user.Logradouro }}</td>
                            </div>
                            <div class="card-body">
                                <td>{{ user.role.name }}</td>
                            </div>
                            <div class="card-body">
                                <td>{{ user.cep }}</td>
                            </div>
                        </div>      
                    </td>       
                </tr>   
            </tbody>
        </table> 
    </div>
</div>
<div>
    <div v-for="user in users" :key="user.id"
        class="card m-3">
        <div class="card-body">
            <router-link
                :to="{ name: 'user-todo', params: { id: user.id }}">
                <th>{{ user.name }}</th>
                <th>{{ user.id }}</th>
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
            });
        },
    }
</script>
   



