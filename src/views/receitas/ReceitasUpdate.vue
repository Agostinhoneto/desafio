<template>
    <br>
    <div>
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
            <input type="text" v-model="this.descricao" class="form-control" id="descricao" placeholder="Descrição" />
          </div>
          <br>
          <div class="form-group col-md-6">
            <label for="valor">Valor</label>
            <input type="number" step="0.01" v-model="this.valor" class="form-control" id="valor" placeholder="Valor" />
          </div>
          <br>
          <div class="form-group col-md-6">
            <label for="data_pagamento">Data de Pagamento</label>
            <input type="date" v-model="this.data_pagamento" class="form-control" id="data_pagamento" />
          </div>
          <br>
          <div class="form-group col-md-6">
            <label for="status">Status</label>
            <select v-model="this.status" class="form-control" id="status">
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
  export default {
    name: "ReceitasUpdateVue",
    data() {
      return {
        id: "",
        descricao: "",
        valor: "",
        data_pagamento: "",
        status: 1,
        categoria_id: "",
        categorias: [],
      };
    },
    async mounted() {
      const receitaId = this.$route.params.id;
      this.id = receitaId;
  
      try {
        // Buscar a receita pelo ID
        const receitaResponse = await fetch(`http://127.0.0.1:8000/api/showReceita/${receitaId}`);
        const receitaData = await receitaResponse.json();
  
        this.descricao = receitaData.descricao;
        this.valor = receitaData.valor;
        this.data_pagamento = receitaData.data_pagamento;
        this.status = receitaData.status;
        this.categoria_id = receitaData.categoria_id;
  
        // Buscar categorias
        const categoriasResponse = await fetch("http://127.0.0.1:8000/api/indexCategorias");
        const categoriasData = await categoriasResponse.json();
        this.categorias = categoriasData.data;
      } catch (error) {
        console.error("Erro ao carregar dados da receita ou categorias:", error);
      }
    },
    methods: {
      async submit() {
        const payload = {
          id: this.id,
          descricao: this.descricao,
          valor: this.valor,
          data_pagamento: this.data_pagamento,
          status: this.status,
          categoria_id: this.categoria_id,
        };
  
        try {
          const response = await fetch(`http://127.0.0.1:8000/api/updateReceita/${this.id}`, {
            method: "PUT",
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
            body: JSON.stringify(payload),
          });
  
          const res = await response.json();
          alert("Receita atualizada com sucesso!");
          this.$router.push({ name: "lista-receitas" });
        } catch (error) {
          console.error("Erro ao atualizar a receita:", error);
          alert("Erro ao atualizar a receita.");
        }
      },
    },
  };
  </script>
  
  <style scoped>
  form {
    margin: 0 auto;
    max-width: 600px;
  }
  </style>
  