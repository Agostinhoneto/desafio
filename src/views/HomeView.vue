<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Lista de Usuários</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <div class="container-fluid">
            <!-- Botões e Filtros -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <router-link :to="{ name: 'cad-usuarios' }" class="btn btn-success btn-sm">
                        <i class="fas fa-user-plus"></i> Adicionar Usuário
                    </router-link>
                </div>
                <div class="input-group" style="width: 300px;">
                    <input type="text" class="form-control" placeholder="Buscar usuário..." v-model="searchQuery">
                    <button class="btn btn-outline-secondary" type="button" @click="filterUsers">Buscar</button>
                </div>
            </div>

            <!-- Table of Users -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gerenciamento de Usuários</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body p-0">
                    <div v-if="loading" class="text-center my-3">Carregando...</div>
                    <table v-else class="table table-striped table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>CPF</th>
                                <th>Perfil</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in filterUser" :key="user.id">
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.cpf }}</td>
                                <td>{{ user.role.name }}</td>
                                <td>
                                    <router-link :to="{ name: 'cad-usuarios', params: { id: user.id } }">
                                        <button type="button" class="btn btn-primary btn-sm">Editar</button>
                                    </router-link>
                                    <router-link :to="{ name: 'cad-usuarios', params: { id: user.id } }">
                                        <button type="button" class="btn btn-warning btn-sm">Desativar</button>
                                    </router-link>
                                    <router-link :to="{ name: 'cad-usuarios', params: { id: user.id } }">
                                        <button type="button" class="btn btn-info btn-sm">Reativar</button>
                                    </router-link>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        @click="confirmDelete(user.id)">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->

                <!-- Paginação -->
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <span>Total de usuários: {{ users.length }}</span>
                    <ul class="pagination pagination-sm m-0">
                        <li class="page-item" :class="{ disabled: currentPage === 1 }">
                            <a class="page-link" href="#" @click="changePage(currentPage - 1)">«</a>
                        </li>
                        <li class="page-item" v-for="page in totalPages" :key="page"
                            :class="{ active: currentPage === page }">
                            <a class="page-link" href="#" @click="changePage(page)">{{ page }}</a>
                        </li>
                        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                            <a class="page-link" href="#" @click="changePage(currentPage + 1)">»</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /.card -->
            <!-- Modal de Confirmação -->
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmação de Deleção</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Tem certeza de que deseja deletar este usuário?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" @click="deleteUser">Deletar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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