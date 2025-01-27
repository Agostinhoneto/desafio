<template>
    <br>
    <div class="content-wrapper">
        <h2>Editar despesa</h2>
        <hr>
        <div>
            <router-link :to="{ name: 'lista-despesas' }">Voltar</router-link>
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
                    <label for="data_recebimento">Data de Pagamento</label>
                    <input type="date" v-model="data_recebimento" class="form-control" id="data_recebimento" />
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
                    <button type="submit" class="btn btn-primary">EDITAR</button>
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
    name: "Editardespesa",
    data() {
        return {
            id: null,
            descricao: "",
            valor: "",
            data_recebimento: "",
            status: "1",
            categoria_id: null,
            categorias: [],
        };
    },
    methods: {
        async carregardespesa() {
            try {
                const id = this.$route.params.id;
                if (!id) throw new Error("ID da despesa não fornecido na rota.");
                
                const response = await axios.get(`http://127.0.0.1:8000/api/showdespesa/${id}`);
                const despesa = response.data.data;

                this.id = despesa.id;
                this.descricao = despesa.descricao || "";
                this.valor = despesa.valor || 0;
                this.data_recebimento = despesa.data_recebimento
                    ? new Date(despesa.data_recebimento).toISOString().split("T")[0]
                    : ""; // Formata para "YYYY-MM-DD"
                this.status = despesa.status !== undefined ? despesa.status.toString() : "1";
                this.categoria_id = despesa.categoria_id || null;
            } catch (error) {
                console.error("Erro ao carregar despesa:", error.message);
                alert("Erro ao carregar despesa.");
                this.$router.push({ name: "lista-despesas" });
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
        // Submete as alterações da despesa
        async submit() {
            try {
                const payload = {
                    descricao: this.descricao,
                    valor: this.valor,
                    data_recebimento: this.data_recebimento,
                    status: this.status,
                    categoria_id: this.categoria_id,
                };

                await axios.put(`http://127.0.0.1:8000/api/updatedespesa/${this.id}`, payload);

                alert("despesa atualizada com sucesso!");
                this.$router.push({ name: "lista-despesas" });
            } catch (error) {
                console.error("Erro ao atualizar despesa:", error);
            }
        },
    },
    mounted: async function () {
        await this.carregarCategorias();
        await this.carregardespesa();
    },
};
</script>
