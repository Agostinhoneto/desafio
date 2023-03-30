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
            :endereco-id="enderecoId"

            @save="onSave"
            @update="onUpdate"
        />
    <div class="row">
     <form @submit.stop.prevent="submit">
     <br><br>
        <div class="row">
            <div class="form-group col-3">
                <label for="exampleInputEmail1">Nome*</label>
                <input type="text" v-model="this.name" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Nome" required>
            </div>
            <div class="form-group col-3">
                <label for="">Email*</label>
                <input type="email" v-model="this.email" class="form-control" id="email" placeholder="Email" required>
            </div>
            <div class="form-group col-3">
                <label for="">CPF*</label>
                <input type="text" v-model="cpf" class="form-control" id="cpf" placeholder="CPF" required>
            </div> 
            <br>
            <div class="form-group col-3">
                <label for="">Pefil*</label>
                <br>
                <select class="form-select" v-model="this.role_id" aria-label="Default select example" required>
                    <option selected> selecione</option>
                    <option value="1">Admin</option>
                    <option value="2">Usuario</option>
                </select>
            </div>
        </div>    
        <hr>
        <div class="row">
            <label><h4>Endereço:</h4></label>
            <div class="form-group col-3">
                <label for="">Logradouro:</label>
                <select class="form-select" v-model="this.logradouro" aria-label="Default select example" required>
                    <option v-for="endereco in enderecos " :key="endereco.id"
                            v-bind:value="endereco.logradouro">
                            {{ endereco.logradouro }}
                    </option>
                </select>   
            </div>    
            <div class="form-group col-3">
                <label for="">Cep:</label>
                <select class="form-select" v-model="this.cep" aria-label="Default select example" required>
                    <option v-for="endereco in enderecos " :key="endereco.id"
                            v-bind:value="endereco.cep">
                            {{ endereco.cep }}
                    </option>
                </select>   
            </div>
            <div>
            <br>
            <router-link :to="{ name: 'user-enderecos'}">
                <button type="submit" class="btn btn-primary">Novo Endereço</button>
            </router-link>
    </div>    
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
    </div>     
    <br><hr> 
</div>
</template>
<script>
export default {
    name: 'UsuariosCadVue',
    
    props: {
            enderecoId: {
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
                this.cep = vl.cep;
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
                    logradouro: this.logradouro, 
                    cep: this.cep, 
                };

                if (this.id) {
                    this.update(payload);
                } else {
                    this.storeTodo(payload);
                    console.log(storeTodo);
                   
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
                        alert('Dados Salvos com Sucesso');
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
            this.cep = resp.cep
                
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
                        alert('Dados Atualizados com Sucesso');
                    });
            }, 
            remover(enderecoId) {
                fetch(`http://127.0.0.1:8000/api/enderecoDestroy/${enderecoId}`,
                {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                })
                .then(() => {
                    const todos = this.endereco;
                    const idx = todos.findIndex(o => o.id === enderecoId);
                    todos.splice(idx, 1);                    
                });
                alert('Dados excluidos com Sucesso');

            },
            resetForm() {
                this.name = '';
                this.email = '';
                this.cpf = '';
                this.role_id = '';
                this.cep = '';
                this.logradouro = '';
            },
            
        },
        data(){
            return {
                users:[],
                id : '',
                name : '',
                email : '',
                cpf :'',
            };
        },  
        async mounted(){
            if (this.$route.params.id){
                await this.show();
            }
            await this.loadEndereco();
        }
};
</script>