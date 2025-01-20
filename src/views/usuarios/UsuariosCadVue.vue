<template>
     <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        <h2 class="my-4">Cadastrar Usuários</h2>
        <div class="card-tools">
          <router-link :to="{ name: 'lista' }" class="btn btn-secondary btn-sm ml-2">
            <i class="fas fa-arrow"></i> Voltar
          </router-link>
          <router-link :to="{ name: 'lista' }" class="btn btn-primary btn-sm ml-2">
                <i class="fas fa-list"></i> Listar Usuários
            </router-link>
        </div>


        <UserTodoForm :todo="updateUser" :user-id="userId" :endereco-id="enderecoId" @save="onSave"
            @update="onUpdate" />

        <form @submit.prevent="submit">
            <!-- Informações do Usuário -->
            <fieldset class="border p-3 mb-4">
                <legend class="w-auto px-2">Informações do Usuário</legend>
                <div class="row g-3">
                    <div class="form-group col-md-6">
                        <label for="name" class="form-label">Nome *</label>
                        <input type="text" v-model="name" class="form-control" id="name" placeholder="Digite o nome" required>
                        <div class="invalid-feedback">O nome é obrigatório.</div>
                    </div>
                
                    <div class="form-group col-md-6">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" v-model="email" class="form-control" id="email" placeholder="Digite o email" required>
                        <div class="invalid-feedback">O email é obrigatório.</div>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="cpf" class="form-label">CPF *</label>
                        <input type="text" v-model="cpf" class="form-control" id="cpf" placeholder="Digite o CPF"
                            required>
                        <div class="invalid-feedback">O CPF é obrigatório.</div>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="role" class="form-label">Perfil *</label>
                        <select class="form-select" v-model="role_id" id="role" required>
                            <option value="" disabled>Selecione</option>
                            <option value="1">Admin</option>
                            <option value="2">Usuário</option>
                        </select>
                        <div class="invalid-feedback">O perfil é obrigatório.</div>
                    </div>
                </div>
            </fieldset>

            <!-- Endereço -->
            <fieldset class="border p-3 mb-4">
                <legend class="w-auto px-2">Endereço</legend>
                <div class="row g-3">
                    <div class="form-group col-md-6">
                        <label for="logradouro" class="form-label">Logradouro *</label>
                        <select class="form-select" v-model="logradouro" id="logradouro" required>
                            <option value="" disabled>Selecione o logradouro</option>
                            <option v-for="endereco in enderecos" :key="endereco.id" :value="endereco.logradouro">
                                {{ endereco.logradouro }}
                            </option>
                        </select>
                        <div class="invalid-feedback">O logradouro é obrigatório.</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cep" class="form-label">CEP *</label>
                        <select class="form-select" v-model="cep" id="cep" required>
                            <option value="" disabled>Selecione o CEP</option>
                            <option v-for="endereco in enderecos" :key="endereco.id" :value="endereco.cep">
                                {{ endereco.cep }}
                            </option>
                        </select>
                        <div class="invalid-feedback">O CEP é obrigatório.</div>
                    </div>
                </div>
            </fieldset>
            <div class="text-end">
                <button type="submit" class="btn btn-success">Adicionar</button>
            </div>
        </form>
    </div>
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
