<template>
    <div class="content-wrapper">
        <h2 class="my-4">Cadastrar Receitas</h2>
        <div class="card-tools">
            <router-link :to="{ name: 'lista-receitas' }" class="btn btn-secondary btn-sm ml-2">
                <i class="fas fa-arrow"></i> Voltar
            </router-link>
            <router-link :to="{ name: 'lista-receitas' }" class="btn btn-primary btn-sm ml-2">
                <i class="fas fa-list"></i> Listar Receitas
            </router-link>
        </div>

        <form @submit.prevent="submit">
            <fieldset class="border p-3 mb-4">
                <legend class="w-auto px-2">Informações da Receitas</legend>
                <div class="row g-3">
                    <div class="form-group col-md-4">
                        <label for="categoria_id" class="form-label">Categoria *</label>
                        <select class="form-select" v-model="categoria_id" id="categoria_id" required>
                            <option value="" disabled>Selecione a categoria</option>
                            <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
                                {{ categoria.descricao }}
                            </option>
                        </select>
                        <div class="invalid-feedback">A categoria é obrigatória.</div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="descricao" class="form-label">Descrição *</label>
                        <input type="text" v-model="descricao" class="form-control" id="descricao"
                            placeholder="Digite a descrição" required />
                        <div class="invalid-feedback">A descrição é obrigatória.</div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="valor" class="form-label">Valor *</label>
                        <input type="number" v-model="valor" class="form-control" id="valor"
                            placeholder="Digite o valor" required />
                        <div class="invalid-feedback">O valor é obrigatório.</div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-3 mb-4">
                <legend class="w-auto px-2">Detalhes da Receita</legend>
                <div class="row g-3">
                    <div class="form-group col-md-4">
                        <label for="data_recebimento" class="form-label">Data de Recebimento *</label>
                        <input type="date" v-model="data_recebimento" class="form-control" id="data_recebimento"
                            required />
                        <div class="invalid-feedback">A data de recebimento é obrigatória.</div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select" v-model="status" id="status" required>
                            <option value="" disabled>Selecione o status</option>
                            <option value="0">Pendente</option>
                            <option value="1">Recebido</option>
                        </select>
                        <div class="invalid-feedback">O status é obrigatório.</div>
                    </div>
                </div>
            </fieldset>
            <div class="text-end">
                <button type="submit" class="btn btn-success">Salvar Receita</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: "ReceitasForm",

    data() {
        return {
            receitas: [],
            categorias: [], 
            despesas: [], 
            id: "",
            categoria_id: "",
            descricao: "",
            valor: "",
            data_recebimento: "",
            status: "",
            despesa_id: "",
        };
    },

    methods: {
        async loadCategorias() {
            try {
                const response = await fetch("http://127.0.0.1:8000/api/indexCategorias");
                const data = await response.json();
                this.categorias = data.data; 
            } catch (error) {
                console.error("Erro ao carregar categorias:", error);
                alert("Erro ao carregar categorias. Tente novamente.");
            }
        },

        async loadDespesas() {
            try {
                const response = await fetch("http://127.0.0.1:8000/api/indexDespesas");
                const data = await response.json();
                this.despesas = data.data; 
            } catch (error) {
                console.error("Erro ao carregar despesas:", error);
                alert("Erro ao carregar despesas. Tente novamente.");
            }
        },

        async show() {
            const receitaId = this.$route.params.id;
            this.id = receitaId;

            try {
                const response = await fetch(`http://127.0.0.1:8000/api/indexReceitas/${receitaId}`);
                const data = await response.json();

                this.categoria_id = data.data.categoria_id;
                this.descricao = data.data.descricao;
                this.valor = data.data.valor;
                this.data_recebimento = data.data.data_recebimento;
                this.status = data.data.status;
                this.despesa_id = data.data.despesa_id;
            } catch (error) {
                console.error("Erro ao carregar a receita:", error);
                alert("Erro ao carregar a receita. Tente novamente.");
            }
        },

        async submit() {
            const payload = {
                id: this.id,
                categoria_id: this.categoria_id,
                descricao: this.descricao,
                valor: this.valor,
                data_recebimento: this.data_recebimento,
                status: this.status,
            };

            if (this.id) {
                this.updateReceita(payload);
            } else {
                this.storeReceita(payload);
            }
        },

        async storeReceita(payload) {
            try {
                const response = await fetch("http://127.0.0.1:8000/api/storeReceitas", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json();
                alert("Receita salva com sucesso!");
                this.resetForm();
            } catch (error) {
                console.error("Erro ao salvar receita:", error);
                alert("Erro ao salvar receita. Tente novamente.");
            }
        },

        async updateReceita(payload) {
            try {
                const response = await fetch(`http://127.0.0.1:8000/api/indexReceitas/${payload.id}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json();
                alert("Receita atualizada com sucesso!");
                this.resetForm();
            } catch (error) {
                console.error("Erro ao atualizar receita:", error);
                alert("Erro ao atualizar receita. Tente novamente.");
            }
        },

        resetForm() {
            this.categoria_id = "";
            this.descricao = "";
            this.valor = "";
            this.data_recebimento = "";
            this.status = "";
        },
    },

    async mounted() {
        if (this.$route.params.id) {
            await this.show();
        }
        await this.loadCategorias();
        await this.loadDespesas();
    },
};
</script>
