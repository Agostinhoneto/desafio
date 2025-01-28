<template>
    <br>
    <div>
        <h2>Cadastrar Usuários</h2>
        <hr>
        <div>
            <router-link :to="{ name: 'home' }">Voltar</router-link>
        </div>
        <UserTodoForm :todo="updateUser" :user-id="userId" @save="onSave" @update="onUpdate" />
        <div class="row">
            <form @submit.stop.prevent="submit">
                <br><br>
                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Nome</label>
                    <input type="text" v-model="this.name" class="form-control" id="name" aria-describedby="emailHelp"
                        placeholder="Nome">
                </div>
                <br>
                <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">CPF</label>
                    <input type="text" v-model="this.cpf" class="form-control" id="cpf" placeholder="CPF">
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
                    <input type="text" v-model="this.role_id" class="form-control" id="role_id" placeholder="Perfil">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Cep</label>
                    <br>
                    <input type="text" v-model="this.role_id" class="form-control" id="role_id" placeholder="Cep">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Logradouro</label>
                    <br>
                    <input type="text" v-model="this.role_id" class="form-control" id="role_id"
                        placeholder="Logradouro">
                </div>
                <br>
                <br>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary">
                        EDITAR
                    </button>
                </div>
            </form>
        </div>
        <br>
        <hr>
        <div class="col-md-9">

        </div>
    </div>
    <div>
    </div>
</template>

<script>
export default {
    name: 'UsuariosUpdateVue',
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
            users: [],
            id: '',
            name: '',
            email: '',
            cpf: '',
            role_id: '',
        };
    },

    watch: {
        todo: {
            handler(newValue) {
                this.id = newValue.id || '';
                this.name = newValue.name || '';
                this.email = newValue.email || '';
                this.cpf = newValue.cpf || '';
                this.logradouro = newValue.logradouro || '';
            },
            immediate: true,
            deep: true,
        },
    },

    methods: {
        async submit() {
            const payload = {
                id: this.id,
                name: this.name,
                email: this.email,
                cpf: this.cpf,
                logradouro: this.logradouro,
            };

            try {
                if (this.id) {
                    await this.updateUser(payload);
                } else {
                    await this.createUser(payload);
                }
            } catch (error) {
                console.error('Erro ao enviar os dados:', error);
            }
        },

        async createUser(payload) {
            try {
                const response = await fetch(`http://localhost:8000/api/storeUsers/`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                const res = await response.json();
                this.$emit('save', res.data);
                this.resetForm();
            } catch (error) {
                console.error('Erro ao criar o usuário:', error);
            }
        },

        async updateUser(payload) {
            try {
                const response = await fetch(`http://localhost:8000/api/updateUsers/${payload.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                const res = await response.json();
                this.$emit('update', res.data);
                this.resetForm();
            } catch (error) {
                console.error('Erro ao atualizar o usuário:', error);
            }
        },

        async removeUser(userId) {
            try {
                await fetch(`http://127.0.0.1:8000/api/destroyUsers/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                    },
                });

                const idx = this.users.findIndex(user => user.id === userId);
                if (idx !== -1) {
                    this.users.splice(idx, 1);
                }

                alert(`Usuário ${userId} removido com sucesso.`);
            } catch (error) {
                console.error('Erro ao remover o usuário:', error);
            }
        },

        resetForm() {
            this.id = '';
            this.name = '';
            this.email = '';
            this.cpf = '';
            this.role_id = '';
        },
    },

    async mounted() {
        const userId = this.$route.params.id || this.userId;

        if (userId) {
            try {
                const response = await fetch(`http://127.0.0.1:8000/api/showUsers/${userId}`);
                const res = await response.json();

                const user = res.data || {};
                this.id = user.id || '';
                this.name = user.name || '';
                this.email = user.email || '';
                this.cpf = user.cpf || '';
                this.role_id = user.role_id || '';
            } catch (error) {
                console.error('Erro ao buscar os dados do usuário:', error);
            }
        }
    },
};
</script>
