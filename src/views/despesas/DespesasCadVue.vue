<template>
    <div class="content-wrapper">
        <h2 class="my-4">Cadastrar Despesas</h2>
        <div class="card-tools">
            <router-link :to="{ name: 'lista-despesas' }" class="btn btn-secondary btn-sm ml-2">
                <i class="fas fa-arrow"></i> Voltar
            </router-link>
            <router-link :to="{ name: 'lista-despesas' }" class="btn btn-danger btn-sm ml-2">
                <i class="fas fa-list"></i> Listar Despesas
            </router-link>
        </div>

        <form @submit.prevent="submit">
            <fieldset class="border p-3 mb-4">
                <legend class="w-auto px-2">Informações da Despesas</legend>
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
                        <label for="user_id" class="form-label">Usuário *</label>
                        <select class="form-select" v-model="user_id" id="user_id" required>
                            <option value="" disabled>Selecione a categoria</option>
                            <option v-for="usuario in usuarios" :key="usuario.id" :value="usuario.id">
                                {{ usuario.name }}
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
                <legend class="w-auto px-2">Detalhes da Despesa</legend>
                <div class="row g-3">
                    <div class="form-group col-md-4">
                        <label for="data_pagamento" class="form-label">Data da despesa *</label>
                        <input type="date" v-model="data_pagamento" class="form-control" id="data_pagamento" required />
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
                <button type="submit" class="btn btn-success">Salvar Despesa</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: "DespesasForm",

    data() {
        return {
            despesas: [],
            categorias: [],
            usuarios: [],
            id: "",
            categoria_id: "",
            user_id: "",
            descricao: "",
            valor: "",
            data_pagamento: "",
            status: "",
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

        async loadUsuarios() {
            try {
                const response = await fetch("http://127.0.0.1:8000/api/indexUsers");
                const data = await response.json();
                this.usuarios = data.data;
            } catch (error) {
                console.error("Erro ao carregar usuarios:", error);
                alert("Erro ao carregar usuarios. Tente novamente.");
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
            const despesaId = this.$route.params.id;
            this.id = despesaId;

            try {
                const response = await fetch(`http://127.0.0.1:8000/api/indexDespesas/${despesaId}`);
                const data = await response.json();

                this.categoria_id = data.data.categoria_id;
                this.user_id = data.data.user_id;
                this.descricao = data.data.descricao;
                this.valor = data.data.valor;
                this.data_pagamento = data.data.data_pagamento;
                this.status = data.data.status;
            } catch (error) {
                console.error("Erro ao carregar a desésa:", error);
                alert("Erro ao carregar a despesa. Tente novamente.");
            }
        },

        async submit() {
            const payload = {
                id: this.id,
                categoria_id: this.categoria_id,
                user_id: this.user_id,
                descricao: this.descricao,
                valor: this.valor,
                data_pagamento: this.data_pagamento,
                status: this.status,
            };

            if (this.id) {
                this.updateDespesa(payload);
            } else {
                this.storeDespesa(payload);
            }
        },

        async storeDespesa(payload) {
            try {
                const response = await fetch("http://127.0.0.1:8000/api/storeDespesas", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json();
                alert("Despesa salva com sucesso!");
                this.resetForm();
            } catch (error) {
                console.error("Erro ao salvar despesa:", error);
                alert("Erro ao salvar despesa. Tente novamente.");
            }
        },

        async updateDespesa(payload) {
            try {
                const response = await fetch(`http://127.0.0.1:8000/api/updateDespesas/${payload.id}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json();
                alert("Despesa atualizada com sucesso!");
                this.resetForm();
            } catch (error) {
                console.error("Erro ao atualizar despesa:", error);
                alert("Erro ao atualizar despesa. Tente novamente.");
            }
        },

        resetForm() {
            this.categoria_id = "";
            this.user_id = "";
            this.descricao = "";
            this.valor = "";
            this.data_pagamento = "";
            this.status = "";
        },
    },

    async mounted() {
        if (this.$route.params.id) {
            await this.show();
        }
        await this.loadCategorias();
        await this.loadUsuarios();
        await this.loadDespesas();

    },
};
</script>
