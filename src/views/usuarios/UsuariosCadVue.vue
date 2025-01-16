<template>
    <br>
    <div>
        <h2>Cadastrar Usuários</h2>
        <hr>
        <div>
            <router-link :to="{ name: 'home' }">
                <button type="submit" class="btn btn-primary">Voltar</button>
            </router-link>
        </div>
        <UserTodoForm :todo="updateUser" :user-id="userId" :endereco-id="enderecoId" @save="onSave"
            @update="onUpdate" />
        <div class="row">
            <form @submit.stop.prevent="submit">
                <br><br>
                <div class="row">
                    <div class="form-group col-3">
                        <label for="exampleInputEmail1">Nome*</label>
                        <input type="text" v-model="this.name" class="form-control" id="name"
                            aria-describedby="emailHelp" placeholder="Nome" required>
                    </div>
                    <div class="form-group col-3">
                        <label for="">Email*</label>
                        <input type="email" v-model="this.email" class="form-control" id="email" placeholder="Email"
                            required>
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
                <div class="form-group col-3">
                    <label for="logradouro">Logradouro:</label>
                    <select class="form-select" v-model="logradouro" required>
                        <option value="" disabled>Selecione o logradouro</option>
                        <option v-for="endereco in enderecos" :key="endereco.id" :value="endereco.logradouro">
                            {{ endereco.logradouro }}
                        </option>
                    </select>
                </div>

                <div class="form-group col-3">
                    <label for="cep">CEP:</label>
                    <select class="form-select" v-model="cep" required>
                        <option value="" disabled>Selecione o CEP</option>
                        <option v-for="endereco in enderecos" :key="endereco.id" :value="endereco.cep">
                            {{ endereco.cep }}
                        </option>
                    </select>
                </div>
                <hr>
                <div class="mt-2">
                    <button type="submit" class="btn btn-success">
                        ADCIONAR
                    </button>
                </div>
                <br><br>
            </form>
            <br>
        </div>
        <br>
        <hr>
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

    data() {
        return {
            users: [],
            enderecos: [], // Armazena a lista de endereços
            id: '',
            name: '',
            email: '',
            cpf: '',
            cep: '',
            logradouro: '',
            role_id: '',
        };
    },

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
        async loadEndereco() {
            try {
                const response = await fetch('http://127.0.0.1:8000/api/enderecoIndex');
                const data = await response.json();
                this.enderecos = data.data; // Supondo que o formato é { data: [...] }
            } catch (error) {
                console.error('Erro ao carregar os endereços:', error);
                alert('Erro ao carregar os endereços. Tente novamente.');
            }
        },

        async show() {
            const userId = this.$route.params.id;
            this.id = userId;

            try {
                const response = await fetch(`http://127.0.0.1:8000/api/show/${userId}`);
                const data = await response.json();

                this.name = data.data.name;
                this.email = data.data.email;
                this.cpf = data.data.cpf;
                this.cep = data.data.cep;
                this.logradouro = data.data.logradouro;
            } catch (error) {
                console.error('Erro ao carregar os dados do usuário:', error);
                alert('Erro ao carregar os dados do usuário. Tente novamente.');
            }
        },

        submit() {
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
            }
        },

        async storeTodo(payload) {
            try {
                const response = await fetch(`http://127.0.0.1:8000/api/store/`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json();
                this.$emit('save', data.data);
                this.resetForm();
                alert('Dados Salvos com Sucesso');
            } catch (error) {
                console.error('Erro ao salvar os dados:', error);
                alert('Erro ao salvar os dados. Tente novamente.');
            }
        },

        async update(payload) {
            try {
                const response = await fetch(
                    `http://127.0.0.1:8000/api/update/${payload.id}`,
                    {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            Accept: 'application/json',
                        },
                        body: JSON.stringify(payload),
                    }
                );

                const data = await response.json();
                this.$emit('update', data.data);
                this.resetForm();
                alert('Dados Atualizados com Sucesso');
            } catch (error) {
                console.error('Erro ao atualizar os dados:', error);
                alert('Erro ao atualizar os dados. Tente novamente.');
            }
        },

        remover(enderecoId) {
            fetch(`http://127.0.0.1:8000/api/enderecoDestroy/${enderecoId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                },
            })
                .then(() => {
                    const idx = this.enderecos.findIndex((o) => o.id === enderecoId);
                    if (idx !== -1) this.enderecos.splice(idx, 1);
                    alert('Dados excluídos com sucesso');
                })
                .catch((error) => {
                    console.error('Erro ao excluir o endereço:', error);
                    alert('Erro ao excluir o endereço.');
                });
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

    async mounted() {
        if (this.$route.params.id) {
            await this.show();
        }
        await this.loadEndereco();
    },
};
</script>
