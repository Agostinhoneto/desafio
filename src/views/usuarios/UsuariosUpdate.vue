<template>
    <br>
    <div>
        <h2>Cadastrar Usuários</h2>
        <hr>
        <div>
            <router-link :to="{ name: 'lista-usuarios' }">Voltar</router-link>
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
import axios from "axios";
export default {
    name: "EditarUsuario",
    data() {
        return {
            id: null,
            name: "",
            email: "",
            cpf: "",
            role_id: null,
            roles: [], // Lista de roles (se necessário)
        };
    },
    methods: {
        // Carrega os dados do usuário
        async carregarUsuario() {
            try {
                const id = this.$route.params.id;
                if (!id) throw new Error("ID do usuário não fornecido na rota.");
                
                const response = await axios.get(`http://127.0.0.1:8000/api/showUsers/${id}`);
                const usuario = response.data.data;

                this.id = usuario.id;
                this.name = usuario.name || "";
                this.email = usuario.email || "";
                this.cpf = usuario.cpf || "";
                this.role_id = usuario.role_id || null;
            } catch (error) {
                console.error("Erro ao carregar usuário:", error.message);
                alert("Erro ao carregar usuário.");
                this.$router.push({ name: "lista-usuarios" });
            }
        },

        // Carrega os roles (se necessário)
        async carregarRoles() {
            try {
                const response = await axios.get("http://127.0.0.1:8000/api/indexRoles");
                this.roles = response.data.data;
            } catch (error) {
                console.error("Erro ao carregar roles:", error);
            }
        },

        // Submete as alterações do usuário
        async submit() {
            try {
                const payload = {
                    name: this.name,
                    email: this.email,
                    cpf: this.cpf,
                    role_id: this.role_id,
                };

                await axios.put(`http://127.0.0.1:8000/api/updateUsers/${this.id}`, payload);

                alert("Usuário atualizado com sucesso!");
                this.$router.push({ name: "lista-usuarios", params: { id: this.id } });
            } catch (error) {
                console.error("Erro ao atualizar usuário:", error);
            }
        },
    },
    mounted: async function () {
        await this.carregarRoles(); // Carregar roles, caso necessário
        await this.carregarUsuario(); // Carregar dados do usuário
    },
};
</script>
