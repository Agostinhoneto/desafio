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
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="despesa in despesas" :key="despesa.id">
                                <td>{{ despesa.data }}</td>
                                <td>{{ despesa.descricao }}</td>
                                <td>{{ despesa.categoria }}</td>
                                <td>R$ {{ despesa.valor }}</td>
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
                            <tr v-for="receita in receitas" :key="receita.id">
                                <td>{{ receita.data }}</td>
                                <td>{{ receita.descricao }}</td>
                                <td>{{ receita.categoria }}</td>
                                <td>R$ {{ receita.valor }}</td>
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
export default {
    data() {
        return {
            totalDespesas: 0,
            totalReceitas: 0,
            saldoFinal: 0,
            despesas: [],
            receitas: []
        };
    },
    methods: {
        async fetchData() {
            try {
                // Exemplo de chamadas de API (substitua pelas suas rotas reais)
                const despesasResponse = await fetch('/api/despesas');
                const receitasResponse = await fetch('/api/receitas');
                
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
