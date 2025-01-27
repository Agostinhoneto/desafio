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
import axios from "axios";
export default {
    name: "EditarDespesa",
    data() {
        return {
            id: null,
            descricao: "",
            valor: "",
            data_recebimento: "",
            status: "1",
            categoria_id: null,
            categorias: [],
        };
    },
    methods: {
        async carregarReceita() {
            try {
                const id = this.$route.params.id;
                if (!id) throw new Error("ID da receita não fornecido na rota.");

                const response = await axios.get(`http://127.0.0.1:8000/api/showReceita/${id}`);
                const receita = response.data.data;

                this.id = receita.id;
                this.descricao = receita.descricao || "";
                this.valor = receita.valor || 0;
                this.data_recebimento = receita.data_recebimento
                    ? new Date(receita.data_recebimento).toISOString().split("T")[0]
                    : ""; // Formata para "YYYY-MM-DD"
                this.status = receita.status !== undefined ? receita.status.toString() : "1";
                this.categoria_id = receita.categoria_id || null;
            } catch (error) {
                console.error("Erro ao carregar receita:", error.message);
                alert("Erro ao carregar receita.");
                this.$router.push({ name: "lista-receitas" });
            }
        },
        // Carrega as categorias
        async carregarCategorias() {
            try {
                const response = await axios.get("http://127.0.0.1:8000/api/indexCategorias");
                this.categorias = response.data.data;
            } catch (error) {
                console.error("Erro ao carregar categorias:", error);
            }
        },
        async submit() {
            try {
                const payload = {
                    descricao: this.descricao,
                    valor: this.valor,
                    data_recebimento: this.data_recebimento,
                    status: this.status,
                    categoria_id: this.categoria_id,
                };

                await axios.put(`http://127.0.0.1:8000/api/updateReceita/${this.id}`, payload);

                alert("Receita atualizada com sucesso!");
                this.$router.push({ name: "lista-receitas" });
            } catch (error) {
                console.error("Erro ao atualizar receita:", error);
            }
        },
    },
    mounted: async function () {
        await this.carregarCategorias();
        await this.carregarReceita();
    },
};
</script>
