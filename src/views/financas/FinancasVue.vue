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
                                <td>{{ despesa.categoria_id }}</td>
                                <td>{{ despesa.valorFormatado }}</td>
                                <td>{{ despesa.status }}</td>
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
                                <th>Data</th>
                                <th>Descrição</th>
                                <th>Categoria</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="receita in ultimasReceitas" :key="receita.id">
                                <td>{{ receita.descricao || 'Categoria não disponível' }}</td>
                                <td>{{ receita.categoria?.descricao || 'Categoria não disponível' }}</td>
                                <td>{{ receita.valor ? `R$ ${parseFloat(receita.valor).toFixed(2)}` : 'Valor não disponível' }}</td>
                                <td>{{ receita.data_recebimento ? formatDate(receita.data_recebimento) : 'Data não disponível' }}</td>
                                <td>{{ receita.status || 'Status não disponível' }}</td>
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
            search: "",
            startDate: "",
            endDate: "",
        };
    },

    // axios
    
    created() {
    axios
        .get("http://127.0.0.1:8000/api/indexDespesas")
        .then((response) => {
            console.log("Resposta da API:", response.data);
            this.ultimasDespesas = response.data.data.map((despesa) => ({
                user_id: despesa.user_id,          
                categoria_id: despesa.categoria_id,
                descricao: despesa.descricao,      
                valor: despesa.valor,              
                data_pagamento: despesa.data_pagamento, 
                status: despesa.status,             
                receita_id: despesa.receita_id,     
                valorFormatado: despesa.valor != null && !isNaN(despesa.valor)
                    ? `R$ ${parseFloat(despesa.valor).toFixed(2).replace('.', ',')}`
                    : 'R$ 0,00', 
            }));
        })
        .catch((error) => {
            console.error("Erro ao buscar despesas:", error);
        }); 

        axios
        .get("http://127.0.0.1:8000/api/indexReceitas")
        .then((response) => {
            console.log("Resposta da API:", response.data);
            this.ultimasReceitas = response.data.data.map((receita) => ({
                categoria_id: receita.categoria_id,
                descricao: receita.descricao,      
                valor: receita.valor,              
                data_pagamento: receita.data_pagamento, 
                status: receita.status,             
                receita_id: receita.receita_id,     
                valorFormatado: receita.valor != null && !isNaN(receita.valor)
                    ? `R$ ${parseFloat(receita.valor).toFixed(2).replace('.', ',')}`
                    : 'R$ 0,00', 
            }));
        })
        .catch((error) => {
            console.error("Erro ao buscar receitas:", error);
        }); 
    },

    // Métodos
    methods: {
        async fetchData() {
            try {
                const despesasResponse = await fetch('http://127.0.0.1:8000/api/indexFinancas');
                const receitasResponse = await fetch('http://127.0.0.1:8000/api/indexFinancas');

                const despesasData = await despesasResponse.json();
                const receitasData = await receitasResponse.json();

                this.despesas = despesasData.ultimasDespesas;
                this.receitas = receitasData.ultimasReceitas;

                this.totalDespesas = despesasData.totalDespesas;
                this.totalReceitas = receitasData.totalReceitas;
                this.saldoFinal = this.totalReceitas - this.totalDespesas;
            } catch (error) {
                console.error('Erro ao carregar dados:', error);
            }
        }
    },
    async listarTodos() {
        this.loading = true;
        try {
            const response = await fetch("http://127.0.0.1:8000/api/indexDespesas");
            const res = await response.json();
            this.ultimasDespesas = Array.isArray(res.data) ? res.data : [];
        } catch (error) {
            console.error("Erro ao carregar Despesa:", error);
        } finally {
            this.loading = false;
        }
    },

    mounted() {
        this.fetchData();
    }
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
