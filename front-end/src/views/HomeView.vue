
<template>
    <br>
    <h2>Lista de Usuários</h2>
    <router-link :to="{ name: 'cad-usuarios'}">
        <button type="submit" class="btn btn-success">Novo</button>
    </router-link>
    <br>
    <form>
        <br><br>
        <div class="form-group col-md-6">
            <label for="nome">Nome</label>
            <br>
            <input type="text" v-model="busca.name"  aria-describedby="emailHelp"   class="form-control" placeholder="Nome">
        </div>
        <br>
        <div class="form-group col-md-6">
            <label for="cpf">CPF</label>
            <input type="cpf" class="form-control" id="cpf" placeholder="CPF">
        </div>
        <br>
        <div class="form-group col-md-2">
            <label for="date">Data Inicio</label>
            <input type="date" class="form-control" id="date" placeholder="Inicio">
        </div> 
        <br>
        <div class="form-group col-md-2">
            <label for="date">Data Fim</label>
            <input type="date" class="form-control" id="date" placeholder="Fim">
        </div>
        <br>
        <button type="submit" class="btn btn-primary" @click="pesquisar(this.name)">Filtrar</button>
    </form>
    <br>
    <hr>
    <div class="search-wrapper">
        <input type="text" v-model="search" placeholder="Pesquisar"/>
    </div>   
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
        <tbody  v-for="user in filterUser "
            :key="user.id">
            <tr>
                <td >{{user.id }}</td>
                <td >{{ formatarDataTempo }}
                    {{user.created_at}}
                </td>
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
        filters: {
            formatarDataTempo(d){
                if(!d) return ''
                d = d.split('T')
                let data = d[0]
                let tempo = d[1]
                data = data.split('-')
                data = data[2] + '/' + data[1] + '/' + data[0]
                return data
                console.log(data)
                tempo = tempo.split('.')
                tempo = tempo[0]
                return data + ' ' + tempo
            }
        },

        data(){
            return {
                urlBase:'http://localhost:8000/api/index',
                busca:{name:''},
                urlFiltro:'',
                search:"",
                users:[
                 //   this.user.name,
                ],
            };
        },
        computed:
        {
            filterUser(){
                //alert(this.user);
                return this.users.filter(
                   user => user.name.includes(this.search)
                );
            }
        } ,
        mounted(){
        fetch('http://127.0.0.1:8000/api/index').then(response=> response.json())
            .then((res) =>{
                this.users = res.data;
            });
        
        const id = this.$route.params.id;
          fetch(`http://127.0.0.1:8000/api/show/${id}`)
          .then(response => response.json())
          .then(res => this.user = res.data);
        },
        
      methods: 
        {
            carregarLista(){
                let url = this.urlBase + '?' + this.urlFiltro  
                .then(response=> response.json())
                .then((res) =>{
                    this.users = res.data;
                });
            },

            pesquisar(){
                let filtro = ''
                for (let chave in this.busca){  
                    if(this.busca[chave]){  
                        if(filtro != ''){
                            filtro += ";"
                        }
                        filtro += chave + ':like' + this.busca[chave]     
                    }
                }
                if(filtro != ''){
                    this.urlFiltro = '&filtro='+filtro
                }
                console.log(this.carregarLista())
                this.carregarLista()
            },

            remover(userId) {
                alert(userId);
                fetch(`http://127.0.0.1:8000/api/destroy/${userId}`,
                    {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                    })
                    .then(() => {
                        const todos = this.user;
                        const idx = todos.findIndex(o => o.id === userId);
                        todos.splice(idx, 1);
                    });
                    alert(userId);
            },
        },
    }
</script>
   



