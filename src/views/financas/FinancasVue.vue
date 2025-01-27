<template>
    <div class="content-wrapper">
        <div class="container my-4">
            <h1>Minhas Finanças</h1>
            <p class="text-muted">Aqui você acompanha suas despesas, receitas e saldo atualizado.</p>
            <hr>

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card text-white bg-danger mb-3">
                        <div class="card-header">Total de Despesas</div>
                        <div class="card-body">
                            <h5 class="card-title">R$ {{ totalDespesas }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header">Total de Receitas</div>
                        <div class="card-body">
                            <h5 class="card-title">R$ {{ totalReceitas }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div :class="['card text-white mb-3', saldoFinal >= 0 ? 'saldo-positivo' : 'saldo-negativo']">
                        <div class="card-header">Saldo Final</div>
                        <div class="card-body">
                            <h5 class="card-title">
                                <i :class="saldoFinal >= 0 ? 'fas fa-arrow-up' : 'fas fa-arrow-down'"></i>
                                R$ {{ saldoFinal }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <h2>Últimas Despesas</h2>
                <p class="text-muted">Confira as despesas recentes lançadas.</p>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Descrição</th>
                                <th>Categoria</th>
                                <th>Valor</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="despesa in ultimasDespesas" :key="despesa.id">
                                <td>{{ despesa.data_pagamento }}</td>
                                <td>{{ despesa.descricao }}</td>
                                <td>{{ despesa.categoriaNome }}</td>
                                <td>{{ despesa.valorFormatado }}</td>
                                <td>{{ statusMap[despesa.status] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a href="/despesas" class="btn btn-primary">Ver todas</a>
            </div>

            <div class="row mt-4">
                <h2>Últimas Receitas</h2>
                <p class="text-muted">Confira as receitas recentes lançadas.</p>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Categoria</th>
                                <th>Valor</th>
                                <th>Data do Recebimento</th>
                                <th>Status</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="receita in ultimasReceitas" :key="receita.id">
                                <td>{{ receita.descricao }}</td>
                                <td>{{ receita.categoriaNome }}</td>
                                <td>{{ receita.valor ? `R$ ${parseFloat(receita.valor).toFixed(2)}` : 'Valor não disponível' }}</td>
                                <td>{{ receita.data_recebimento}}</td>
                                <td>{{ statusMap[receita.status]}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a href="/receitas" class="btn btn-primary">Ver todas</a>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            totalDespesas: 0,
            totalReceitas: 0,
            saldoFinal: 0,
            despesas: [],
            ultimasDespesas: [],
            ultimasReceitas: [],
            receitas: [],
            categorias: {},
            search: "",
            startDate: "",
            endDate: "",
            statusMap: {
                1: 'Ativo',
                0: 'Inativo',
            },
        };
    },

    created() {
        // Carregar categorias, despesas e receitas em paralelo
        Promise.all([this.fetchCategorias(), this.fetchDespesas(), this.fetchReceitas()])
            .then(() => {
                console.log("Dados carregados com sucesso.");
            })
            .catch((error) => {
                console.error("Erro ao carregar os dados:", error);
            });
    },

    methods: {
        // Busca categorias e formata o resultado
        async fetchCategorias() {
            try {
                const response = await axios.get("http://127.0.0.1:8000/api/indexCategorias");
                console.log("Categorias carregadas:", response.data);
                this.categorias = response.data.data.reduce((map, categoria) => {
                    map[categoria.id] = categoria.descricao;
                    return map;
                }, {});
            } catch (error) {
                console.error("Erro ao buscar categorias:", error);
            }
        },

        // Busca despesas e formata o resultado
        async fetchDespesas() {
            try {
                const response = await axios.get("http://127.0.0.1:8000/api/indexDespesas");
                console.log("Despesas carregadas:", response.data);
                this.ultimasDespesas = response.data.data.map((despesa) => ({
                    user_id: despesa.user_id,
                    descricao: despesa.descricao,
                    valor: despesa.valor,
                    data_pagamento: despesa.data_pagamento,
                    status: despesa.status,
                    receita_id: despesa.receita_id,
                    valorFormatado: despesa.valor
                        ? `R$ ${parseFloat(despesa.valor).toFixed(2).replace('.', ',')}`
                        : 'R$ 0,00',
                    categoriaNome: this.categorias[despesa.categoria_id] || 'Sem Categoria',
                    statusNome: this.statusMap[despesa.status] || 'Indefinido',
                }));
            } catch (error) {
                console.error("Erro ao buscar despesas:", error);
            }
        },

        // Busca receitas e formata o resultado
        async fetchReceitas() {
            try {
                const response = await axios.get("http://127.0.0.1:8000/api/indexReceitas");
                console.log("Receitas carregadas:", response.data);
                this.ultimasReceitas = response.data.data.map((receita) => ({
                    categoria_id: receita.categoria_id,
                    descricao: receita.descricao,
                    valor: receita.valor,
                    data_recebimento: receita.data_recebimento,
                    status: receita.status,
                    receita_id: receita.receita_id,
                    valorFormatado: receita.valor
                        ? `R$ ${parseFloat(receita.valor).toFixed(2).replace('.', ',')}`
                        : 'R$ 0,00',
                    categoriaNome: this.categorias[receita.categoria_id] || 'Sem Categoria',
                    statusNome: this.statusMap[receita.status] || 'Indefinido',
                }));
            } catch (error) {
                console.error("Erro ao buscar receitas:", error);
            }
        },

        // Método para listar todas as despesas (opcional)
        async listarTodos() {
            this.loading = true;
            try {
                const response = await axios.get("http://127.0.0.1:8000/api/indexDespesas");
                this.ultimasDespesas = response.data.data || [];
            } catch (error) {
                console.error("Erro ao listar despesas:", error);
            } finally {
                this.loading = false;
            }
        },

        // Atualizar os saldos financeiros
        calcularSaldos() {
            this.totalDespesas = this.ultimasDespesas.reduce((acc, despesa) => acc + parseFloat(despesa.valor || 0), 0);
            this.totalReceitas = this.ultimasReceitas.reduce((acc, receita) => acc + parseFloat(receita.valor || 0), 0);
            this.saldoFinal = this.totalReceitas - this.totalDespesas;
        },
    },

    watch: {
        // Atualiza os saldos automaticamente ao carregar as despesas e receitas
        ultimasDespesas: "calcularSaldos",
        ultimasReceitas: "calcularSaldos",
    },
};
</script>



<style>
.card-header {
    font-weight: bold;
}

.saldo-positivo {
    background-color: #28a745 !important;
}

.saldo-negativo {
    background-color: #dc3545 !important;
}

.table-responsive {
    overflow-x: auto;
}
</style>
