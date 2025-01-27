<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Lista de Receitas</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <router-link :to="{ name: 'cad-receitas' }" class="btn btn-primary btn-sm">
                        <i class="fas fa-user-plus"></i> Adicionar Receitas
                    </router-link>
                </div>
                <div class="input-group" style="width: 300px;">
                    <input type="text" class="form-control" placeholder="Buscar receitas..." v-model="searchQuery">
                    <button class="btn btn-outline-secondary" type="button" @click="filterReceitas">Buscar</button>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gerenciamento de Receitas</h3>
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
                            <tr v-for="receita in filterReceita" :key="receita.id">
                                <td>{{ receita.descricao || 'Categoria não disponível' }}</td>
                                <td>{{ receita.categoria.descricao || 'Categoria não disponível' }}</td>
                                <td>{{ receita.valor ? `R$ ${parseFloat(receita.valor).toFixed(2)}` : 'Valor não disponível' }}</td>
                                <td>{{ receita.data_recebimento ? formatDate(receita.data_recebimento) : 'Data não disponível' }}</td>
                                <td>{{ receita.status || 'Status não disponível' }}</td>
                                <td>
                                    <router-link :to="{ name: 'cad-receitas', params: { id: receita.id } }">
                                        <button type="button" class="btn btn-primary btn-sm">Editar</button>
                                    </router-link>
                                    <button type="button" class="btn btn-warning btn-sm"
                                        @click="alterarStatus(receita.id, 'desativar')">Desativar</button>
                                    <button type="button" class="btn btn-info btn-sm"
                                        @click="alterarStatus(receita.id, 'reativar')">Reativar</button>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        @click="confirmDelete(receita.id)">Excluir</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <span>Total de Receitas: {{ receitas.length }}</span>
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
                            <button type="button" class="btn btn-danger" @click="deleteReceita">Deletar</button>
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
            receitas: [],
            startDate: "",
            endDate: "",
            loading: false,
        };
    },
    computed: {
        filterReceita() {
            return this.receitas.filter((receita) => {
                const searchText = this.search.toLowerCase();
                const receitaCreatedAt = moment(receita.created_at).format("YYYY-MM-DD");
                const isWithinDateRange =
                    this.startDate && this.endDate
                        ? receitaCreatedAt >= this.startDate && receitaCreatedAt <= this.endDate
                        : true;

                return (
                    isWithinDateRange &&
                    (receita.descricao.toLowerCase().includes(searchText) ||
                        receita.valor.includes(this.search) ||
                        receita.status.toLowerCase().includes(searchText))
                );
            });
        },
    },
    methods: {
        formatDate(date) {
            if (!date) return 'Data não disponível';
            return new Date(date).toLocaleDateString('pt-BR');
        },
        formatCurrency(value) {
            if (!value) return 'Valor não disponível';
            const numberValue = parseFloat(value);
            if (isNaN(numberValue)) return 'Valor inválido';
            return `R$ ${numberValue.toFixed(2)}`;
        },
        confirmDelete(id) {
            if (confirm('Tem certeza que deseja excluir esta receita?')) {
                // Lógica para deletar a receita
                console.log(`Excluindo receita com ID: ${id}`);
            }
        },
        alterarStatus(id, status) {
            if (status === 'desativar') {
                // Lógica para desativar a receita
                console.log(`Desativando receita com ID: ${id}`);
            } else if (status === 'reativar') {
                // Lógica para reativar a receita
                console.log(`Reativando receita com ID: ${id}`);
            }
        },
        async listarTodos() {
            this.loading = true;
            try {
                const response = await fetch("http://127.0.0.1:8000/api/indexReceitas");
                const res = await response.json();
                this.receitas = res.data;
            } catch (error) {
                console.error("Erro ao carregar receitas:", error);
            } finally {
                this.loading = false;
            }
        },
        async remover(receitaId) {
            if (!confirm("Deseja realmente excluir este receita?")) return;

            try {
                await fetch(`http://127.0.0.1:8000/api/ReceitasDestroy/${receitaId}`, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                });
                alert("Receita excluído com sucesso!");
                await this.listarTodos();
            } catch (error) {
                console.error("Erro ao excluir receita:", error);
            }
        },
    },
    async mounted() {
        await this.listarTodos();
    },
};
</script>
