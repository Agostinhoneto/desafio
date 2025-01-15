<template>
    <br>
    <div>
        <h2>Cadastrar Endereços</h2>
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
                    <label for="exampleInputEmail1">Logradouro*</label>
                    <input type="text" v-model="this.logradouro" class="form-control" id="logradouro" aria-describedby="emailHelp" placeholder="Nome" required>
                </div>
                <div class="form-group col-3">
                    <label for="">CEP*</label>
                    <input type="text" v-model="this.cep" class="form-control" id="cep" placeholder="CEP" required>
                </div>
                <br>
            </div>    
            <hr>
            <div class="mt-2">
                <button type="submit"
                    class="btn btn-success"
                >
                    ADCIONAR ENDEREÇO
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
              
                <tbody  v-for="endereco in enderecos "
                        :key="endereco.id">
                    <tr>
                        <td >{{endereco.id }}</td>
                        <td >{{endereco.logradouro }}</td>
                        <td> {{endereco.cep }}</td>
                        <small>
                            <a
                                href=""
                                class="text-danger"
                                @click.stop.prevent="remover(endereco.id)"
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
                    this.logradouro = vl.logradouro;
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
                        logradouro: this.logradouro,
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
                    }
                },

               async storeTodo(payload) {
                    fetch(`http://localhost:8000/api/storeEndereco/`,
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
                    await this.loadEndereco();               

                    alert('Dados Salvos com Sucesso');

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
                console.log('response',resp)
                },
                
                async remover(enderecoId) {
                await fetch(`http://127.0.0.1:8000/api/enderecoDestroy/${enderecoId}`,
                {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                })
                .then(() => {
                    const todos = this.user;
                  //  const idx = user.findIndex(o => o.id === userId);
                   // todos.splice(idx, 1);
                });
               
                await this.loadEndereco();
               
                alert('Dados excluidos com Sucesso');
                },

                resetForm() {
                    this.cep = '';
                    this.logradouro = '';
                },
            },

            data(){
                return {
                    users:[],
                    id : '',
                    logradouro : '',
                    cep : '',
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