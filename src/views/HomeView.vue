<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Lista de Usuários</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <div>
            <div class="mt-3" striped hover :users="users"></div>
            <br />
            <!-- Filtro -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Table of Users -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gerenciamento de Usuários</h3>
                        <div class="card-tools">
                            <router-link :to="{ name: 'cad-usuarios' }" class="btn btn-success btn-sm">
                                <i class="fas fa-user-plus"></i> Adicionar Usuário
                            </router-link>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <hr />
                        <div v-if="loading">Carregando...</div>
                        <table v-else class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Data de Cadastro</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>CPF</th>
                                    <th>Perfil</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in filterUser" :key="user.id">
                                    <td>{{ user.id }}</td>
                                    <td>{{ formatDate(user.created_at) }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.cpf }}</td>
                                    <td>{{ user.role.name }}</td>
                                    <td>
                                        <router-link :to="{ name: 'user-todo', params: { id: user.id } }">
                                            <button type="button" class="btn btn-light">Detalhar</button>
                                        </router-link>
                                        |
                                        <router-link :to="{ name: 'cad-usuarios', params: { id: user.id } }">
                                            <button type="button" class="btn btn-primary">Editar</button>
                                        </router-link>
                                        |
                                        <button type="button" class="btn btn-danger"
                                            @click.stop.prevent="remover(user.id)">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
    </div>
</template>

<script>
import moment from "moment";

export default {
    data() {
        return {
            search: "",
            users: [],
            startDate: "",
            endDate: "",
            loading: false,
        };
    },
    computed: {
        filterUser() {
            return this.users.filter((user) => {
                const searchText = this.search.toLowerCase();
                const userCreatedAt = moment(user.created_at).format("YYYY-MM-DD");
                const isWithinDateRange =
                    this.startDate && this.endDate
                        ? userCreatedAt >= this.startDate && userCreatedAt <= this.endDate
                        : true;

                return (
                    isWithinDateRange &&
                    (user.name.toLowerCase().includes(searchText) ||
                        user.cpf.includes(this.search) ||
                        user.email.toLowerCase().includes(searchText))
                );
            });
        },
    },
    methods: {
        formatDate(date) {
            return moment(date).format("DD/MM/YYYY, HH:mm:ss");
        },
        async listarTodos() {
            this.loading = true;
            try {
                const response = await fetch("http://127.0.0.1:8000/api/index");
                const res = await response.json();
                this.users = res.data;
            } catch (error) {
                console.error("Erro ao carregar usuários:", error);
            } finally {
                this.loading = false;
            }
        },
        async remover(userId) {
            if (!confirm("Deseja realmente excluir este usuário?")) return;

            try {
                await fetch(`http://127.0.0.1:8000/api/destroy/${userId}`, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                });
                alert("Usuário excluído com sucesso!");
                await this.listarTodos();
            } catch (error) {
                console.error("Erro ao excluir usuário:", error);
            }
        },
    },
    async mounted() {
        await this.listarTodos();
    },
};
</script>

<style>
@import "../assets/app.css"
</style>