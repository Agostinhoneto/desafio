<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Lista de Despesas</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <router-link :to="{ name: 'cad-despesas' }" class="btn btn-success btn-sm">
                        <i class="fas fa-user-plus"></i> Adicionar Despesas
                    </router-link>
                </div>
                <div class="input-group" style="width: 300px;">
                    <input type="text" class="form-control" placeholder="Buscar despesas..." v-model="searchQuery">
                    <button class="btn btn-outline-secondary" type="button" @click="filterDespesa">Buscar</button>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gerenciamento de Despesas</h3>
                </div>
                <div class="card-body p-0">
                    <div v-if="loading" class="text-center my-3">Carregando...</div>
                    <table v-else class="table table-striped table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Categoria</th>
                                <th>Valor</th>
                                <th>Data de Pagamento</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="despesa in filterDespesas" :key="despesa.id">
                                <td>{{ despesa.descricao || 'Categoria não disponível' }}</td>
                                <td>{{ despesa.categoria?.descricao || 'Categoria não disponível' }}</td>
                                <td>{{ despesa.valor ? `R$ ${parseFloat(despesa.valor).toFixed(2)}` : 'Valor não disponível' }}</td>
                                <td>{{ despesa.data_pagamento ? formatDate(despesa.data_pagamento) : 'Data não disponível' }}</td>
                                <td>{{ despesa.status || 'Status não disponível' }}</td>
                                <td>
                                    <router-link :to="{ name: 'cad-despesas', params: { id: despesa.id } }">
                                        <button type="button" class="btn btn-primary btn-sm">Editar</button>
                                    </router-link>
                                    <button type="button" class="btn btn-warning btn-sm"
                                        @click="alterarStatus(despesa.id, 'desativar')">Desativar</button>
                                    <button type="button" class="btn btn-info btn-sm"
                                        @click="alterarStatus(despesa.id, 'reativar')">Reativar</button>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        @click="confirmDelete(despesa.id)">Excluir</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <span>Total de despesas: {{ despesas.length }}</span>
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
            despesas: [], 
            startDate: "",
            endDate: "",
            loading: false,
        };
    },
    computed: {
        filterDespesas() {
            return this.despesas.filter((despesa) => {
                const searchText = this.search.toLowerCase();
                const despesaCreatedAt = despesa.data_pagamento
                    ? moment(despesa.data_pagamento).format("YYYY-MM-DD")
                    : "";

                const isWithinDateRange =
                    this.startDate && this.endDate
                        ? despesaCreatedAt >= this.startDate && despesaCreatedAt <= this.endDate
                        : true;

                return (
                    isWithinDateRange &&
                    (despesa.descricao?.toLowerCase().includes(searchText) || // Verifica se `descricao` existe
                        despesa.valor?.toString().includes(this.search) || // Verifica se `valor` existe
                        despesa.email?.toLowerCase().includes(searchText)) // Verifica se `email` existe
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
                const response = await fetch("http://127.0.0.1:8000/api/indexDespesas");
                const res = await response.json();
                this.despesas = Array.isArray(res.data) ? res.data : []; 
            } catch (error) {
                console.error("Erro ao carregar Despesa:", error);
            } finally {
                this.loading = false;
            }
        },
        async remover(despesaId) {
            if (!confirm("Deseja realmente excluir este Despesa?")) return;

            try {
                await fetch(`http://127.0.0.1:8000/api/DespesasDestroy/${despesaId}`, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                });
                alert("Despesa excluído com sucesso!");
                await this.listarTodos();
            } catch (error) {
                console.error("Erro ao excluir Despesa:", error);
            }
        },
    },
    async mounted() {
        await this.listarTodos();
    },
};
</script>
