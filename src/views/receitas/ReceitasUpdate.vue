<template>
    <br>
    <div class="content-wrapper">
        <h2>Editar Receita</h2>
        <hr>
        <div>
            <router-link :to="{ name: 'lista-receitas' }">Voltar</router-link>
        </div>
        <div class="row">
            <form @submit.stop.prevent="submit">
                <br><br>
                <div class="form-group col-md-6">
                    <label for="descricao">Descrição</label>
                    <input type="text" v-model="descricao" class="form-control" id="descricao"
                        placeholder="Descrição" />
                </div>
                <br>
                <div class="form-group col-md-6">
                    <label for="valor">Valor</label>
                    <input type="number" step="0.01" v-model="valor" class="form-control" id="valor"
                        placeholder="Valor" />
                </div>
                <br>
                <div class="form-group col-md-6">
                    <label for="data_pagamento">Data de Pagamento</label>
                    <input type="date" v-model="data_pagamento" class="form-control" id="data_pagamento" />
                </div>
                <br>
                <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select v-model="status" class="form-control" id="status">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>
                <br>
                <div class="form-group col-md-6">
                    <label for="categoria_id">Categoria</label>
                    <select v-model="categoria_id" class="form-control" id="categoria_id">
                        <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
                            {{ categoria.descricao }}
                        </option>
                    </select>
                </div>
                <br><br>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary">SALVAR</button>
                </div>
            </form>
        </div>
        <br />
        <hr />
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "EditarReceita",
    data() {
        return {
            id: null,
            descricao: "",
            valor: "",
            data_pagamento: "",
            status: "1",
            categoria_id: null,
            categorias: [],
        };
    },
    methods: {
        async carregarReceita() {
            try {
                const id = this.$route.params.id;
                if (!id) {
                    throw new Error("ID da receita não fornecido na rota.");
                }
                const response = await axios.get(`http://127.0.0.1:8000/api/showReceita/${id}`);
                if (!response.data || !response.data.data) {
                    throw new Error("Receita não encontrada ou resposta inválida da API.");
                }
                const receita = response.data.data;
                this.id = receita.id;
                this.descricao = receita.descricao || "";
                this.valor = receita.valor || 0;
                this.data_pagamento = receita.data_pagamento || "";
                this.status = receita.status !== undefined ? receita.status.toString() : "1";
                this.categoria_id = receita.categoria_id || null;
            } catch (error) {
                console.error("Erro ao carregar receita:", error.message);
                alert("Erro ao carregar receita. Por favor, tente novamente.");
                this.$router.push({ name: "lista-receitas" }); // Redireciona para a lista em caso de erro
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
        // Submete as alterações da receita
        async submit() {
            try {
                const payload = {
                    descricao: this.descricao,
                    valor: this.valor,
                    data_pagamento: this.data_pagamento,
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
    async mounted() {
        await this.carregarCategorias();
        await this.carregarReceita();
    },
};
</script>