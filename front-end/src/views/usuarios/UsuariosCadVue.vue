<template>
<br>
<div>
    <h2>Cadastrar Usuários</h2>
    <hr> 
    <div>
        <router-link :to="{ name: 'home'}">
            <button type="submit" class="btn btn-success">Voltar</button>
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
            <label for="exampleInputPassword1">CPF</label>
            <input type="text" v-model="cpf" class="form-control" id="cpf" placeholder="CPF">
        </div>
        <br>
        <div class="form-group col-md-6">
            <label for="exampleInputPassword1">Email</label>
            <br>
            <input type="email" v-model="this.email" class="form-control" id="email" placeholder="Email">
        </div>
        <div class="form-group col-md-6">
            <label for="">Pefil</label>
            <br>
            <select class="form-select" v-model="this.role_id" aria-label="Default select example">
                <option selected> selecione</option>
                <option value="1">Admin</option>
                <option value="2">Usuario</option>
            </select>
        </div>
        <br>
        <br>
        <div class="mt-2">
            <button type="submit"
                class="btn btn-success"
            >
                SALVAR
            </button>
            <meu-botao
            tipo="button"
            rotulo="remover"
            @botaoAtivado="remover(userId)"
            />
        </div>
    </form> 
    </div>     
    <br><hr>     
    <div class="col-md-9">
       
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
        /*
    computed: {
        userId() {
            return this.$route.params.id;
        },
    },
    */
        /*
        data() {
            return {
                id: null,
                name: '',
                email: '',
                cpf: '',
                logradouro: '',
            };
        },
        */
        data() {
        return {
            user: {},
            toBeUpdated: {},
            };
        },
        
        watch: {
            todo(vl) {
                this.id = vl.id;
                this.name = vl.name;
                this.email = vl.email;
                this.cpf = vl.cpf;
                this.logradouro = vl.logradouro;
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
            
          /*  fetch('http://127.0.0.1:8000/api/index').then(response=> response.json())
            .then((res) =>{
                this.users = res.data;
            });
           */ 
        }, 
       

        /*
        mounted(){
            fetch('http://127.0.0.1:8000/api/index').then(response=> response.json())
            .then((res) =>{
                this.users = res.data;
            });
        }, 
        */
};
</script>