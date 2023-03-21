<template>
<br>
<div>
    <h2>Cadastrar Usuários</h2>
    <hr> 
    <div>
        <router-link :to="{ name: 'home'}">
            <button type="submit" class="btn btn-primary">Voltar</button>
        </router-link>
    </div>
        <UserTodoForm
            :todo="updateUser"
            :user-id="userId"
            @save="onSave"
            @update="onUpdate"
        />
    <div class="row">
     <form @submit.stop.prevent="submit">
        <br><br>
        <div class="form-group col-md-6">
            <label for="exampleInputEmail1">Nome</label>
            <input type="text" v-model="this.name" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Nome">
        </div>
        <br>
        <div class="form-group col-md-6">
            <label for="">CPF</label>
            <input type="text" v-model="cpf" class="form-control" id="cpf" placeholder="CPF">
        </div>
        <br>
        <div class="form-group col-md-6">
            <label for="">Email</label>
            <br>
            <input type="email" v-model="this.email" class="form-control" id="email" placeholder="Email">
        </div>
        <br>
        <div class="form-group col-md-2">
            <label for="">Pefil</label>
            <br>
            <select class="form-select" v-model="this.role_id" aria-label="Default select example">
                <option selected> selecione</option>
                <option value="1">Admin</option>
                <option value="2">Usuario</option>
            </select>
        </div>
        <hr>
        <label><h4>Endereço:</h4></label>
        <div class="form-group col-md-6">
            <br>
            <label for="exampleInputPassword1">Logradouro:</label>
            <br>
            <input type="text" v-model="this.logradouro" class="form-control" id="email" placeholder="Logradouro">
        </div>
        <br>
        <div class="form-group col-md-6">
            <label for="exampleInputPassword1">CEP:</label>
            <br>
            <input type="text" v-model="this.cep" class="form-control" id="email" placeholder="CEP">
        </div>
        <hr>
        <div class="mt-2">
            <button type="submit"
                class="btn btn-success"
            >
                ADCIONAR
            </button>
        </div>
        <br><br>
        </form>
        <br>
        <label for=""><h4>Lista de Endereço :</h4></label>
        <table  class="table">
            <thead>
                <tr>
                <th >#</th>
                <th >Logradouro</th>
                <th >CEP</th>
                <th >Ações</th>
                </tr>
            </thead>
            <tbody  v-for="endereco in enderecos">
                <tr>
                    <td >{{endereco.id }}</td>
                    <td >{{endereco.logradouro }}</td>
                    <td> {{endereco.cep }}</td>
                    <small>
                        <a
                            href=""
                            class="text-danger"
                            @click.stop.prevent="remover(user.id)"
                        >
                            <button type="button" class="btn btn-danger"> Delete</button>
                        </a>
                    </small>
                </tr>
            </tbody>        
        </table>
    </div>     
    <br><hr> 
</div>
</template>
<script>
export default {
    name: 'UsuariosCadVue',
    
    props: {
            userId: {
                type: [String, Number],
                default: null,
            },
           
        },
        /*
        data(){
            return {
                users:[],
            };
        }, 
         */
        watch: {
            todo(vl) {
                this.id = vl.id;
                this.name = vl.name;
                this.email = vl.email;
                this.cpf = vl.cpf;
            },
        },
        methods: {
            submit() {
                console.log('id',this.id);
                const payload = {
                    id: this.id,
                    name: this.name,
                    email: this.email,
                    cpf: this.cpf,
                    role_id: this.role_id, 
                  //  logradouro: this.logradouro, 
                   // cep: this.cep,        
                };

                if (this.id) {
                    this.update(payload);
                } else {
                    this.storeTodo(payload);
                }
            },


            storeTodo(payload) {
                fetch(`http://localhost:8000/api/store/`,
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(response => response.json())
                    .then((res) => {
                        this.$emit('save', res.data);
                        this.resetForm()
                    });
            },

            async loadEndereco(){  
             await fetch('http://127.0.0.1:8000/api/enderecoIndex').then(response=> response.json())
                .then((res) =>{
                    this.enderecos = res.data;
                });
            },
            
            async show(){
                
            const userId = this.$route.params.id;
            var resp = null;
            this.id = userId;
            await fetch(`http://127.0.0.1:8000/api/show/${userId}`)
            .then(response => response.json())
            .then(res => resp = {...res.data});
            this.name = resp.name
            this.email = resp.email
            this.cpf = resp.cpf
          //this.role_id = resp.role_id
            console.log('response',resp)    

            },
            update(payload){
                console.log(payload);
                fetch(`http://localhost:8000/api/update/${payload.id}`,
                    {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(response => response.json())
                    .then((res) => {
                        this.$emit('update', res.data);
                        this.resetForm()
                    });
            }, 
            remover(userId) {
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
            },
            resetForm() {
                this.name = '';
                this.email = '';
                this.cpf = '';
                this.role_id = '';
            },
            
        },
        data(){
            return {
                users:[],
                id : '',
                name : '',
                email : '',
                cpf :'',
                role_id :'',
                
            };
        },  


        /*
        async mounted(){
            const userId = this.$route.params.id;
            var resp = null;
            this.id = userId;
            await fetch(`http://127.0.0.1:8000/api/show/${userId}`)
            .then(response => response.json())
            .then(res => resp = {...res.data});
            this.name = resp.name
            this.email = resp.email
            this.cpf = resp.cpf
            this.role.name = resp.role_id
            console.log('response',resp)    
            
        },   
        */
        async mounted(){
            if (this.$route.params.id){
                await this.show();
            }
            await this.loadEndereco();
        }
};
</script>