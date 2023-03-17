<template>
<br>
<div>
    <h2>Cadastrar Usuários</h2>
    <hr> 
    <div>
        <router-link :to="{ name: 'home'}">Voltar</router-link>
    </div>
    <div class="row">
     <form @submit.stop.prevent="submit">
               <br><br>
        <div class="form-group col-md-6">
            <label for="exampleInputEmail1">Nome</label>
            <input type="text" v-model="name" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Nome">
        </div>
        <br>
        <div class="form-group col-md-6">
            <label for="exampleInputPassword1">CPF</label>
            <input type="number" v-model="cpf" class="form-control" id="cpf" placeholder="CPF">
        </div>
        <br>
        <div class="form-group col-md-6">
            <label for="exampleInputPassword1">Email</label>
            <br>
            <input type="email" v-model="email" class="form-control" id="email" placeholder="Email">
        </div>
        <br>
        <div class="form-group col-md-6">
            <label for="exampleInputPassword1">Perfil</label>
            <br>
            <select type="" v-model="role_id"  id="role_id" class="form-select" aria-label="Default select example">
                <option value="1">Admin</option>
                <option value="2">Usuário</option>
            </select>
        </div>
        <br>
        <div class="form-group col-md-6">
            <label for="exampleInputPassword1">Logradouro</label>
            <input type="text" v-model="logradouro" class="form-control" id="logradouro" placeholder="Logradouro">
        </div>
        <br>
        <div class="form-group col-md-2">
            <label for="exampleInputPassword1">Cep</label>
            <input type="number" v-model="cep" class="form-control" id="cep" placeholder="Cep">
        </div> 
        <br>
        <div class="mt-2">
            <button
                type="submit"
                class="btn btn-primary"
            >
                ENVIAR
            </button>
        </div>
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
                            <div>
                            <div>
                                <small>
                                    <a
                                        href=""
                                        class="text-primary"
                                        @click.stop.prevent="toBeUpdated = todo"
                                    >
                                        Update
                                    </a>
                                </small>

                                |
                                    
                                <small>
                                    <a
                                        href=""
                                        class="text-danger"
                                        @click.stop.prevent="deleteTodo(todo.id)"
                                    >
                                        Delete
                                    </a>
                                </small>
                            </div>
                          </div>
                        </div>  
                            
                    </td>       
                </tr>   
            </tbody>
        </table> 
    </div>
</div>
<div>
</div>
</template>
<script>

export default {
    name: 'UsuariosCadVue',
    
    props: {
            todo: {
                type: Object,
                default: () => ({}),
            },

            userId: {
                type: [String, Number],
                default: null,
            },
        },

        data() {
            return {
                id: null,
                name: '',
                email: '',
          //      dueDate: '',
            //    isDone: true,
            };
        },

        watch: {
            todo(vl) {
                this.id = vl.id;
                this.name = vl.name;
                this.email = vl.email;
                //this.dueDate = vl.due_date;
                //this.isDone = vl.is_done;
            },
        },

        methods: {
            submit() {
                const payload = {
                    name: this.name,
                    email: this.email,
                    cpf: this.cpf,
                    logradouro: this.logradouro,
                    cep: this.cep,
                    role_id: this.role_id,
                  
                };

                if (this.id) {
                    this.updateTodo(payload);
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
            updateTodo(payload) {
                fetch(`http://localhost:8000/api/update/${this.id}`,
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

            resetForm() {
                this.name = '';
                this.email = '';
                this.cep = '';
                this.logradouro = '';
            },
            
        },

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

        deleteTodo(userId) {
            fetch(`http://127.0.0.1:8000/api/destroy/${id}`,
                {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                })
                .then(() => {
                    const todos = this.user.todos;
                    const idx = todos.findIndex(o => o.id === userId);
                    todos.splice(idx, 1);
                });
        },
};
    /*
    props: {
    todo: {
        type: Object,
        default: () => ({}),
    },

    userId: {
        type: [String, Number],
        default: null,
    },
    },
   

    
     */

</script>
   



