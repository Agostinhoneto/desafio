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
      <div class="container mt-4">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title">Relatórios</h3>
            <button class="btn btn-sm btn-light" @click="printPage">
              <i class="fas fa-print"></i> Imprimir
            </button>
          </div>
          <div class="card-body">
            <!-- Filtros -->
            <form @submit.prevent="filterDespesas" class="row g-3 mb-4">
              <div class="col-md-6">
                <label for="startDate" class="form-label">Data Inicial:</label>
                <input type="date" v-model="filters.startDate" id="startDate" class="form-control" required />
              </div>
              <div class="col-md-6">
                <label for="endDate" class="form-label">Data Final:</label>
                <input type="date" v-model="filters.endDate" id="endDate" class="form-control" required />
              </div>
              <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-success">
                  <i class="fas fa-filter"></i> Filtrar
                </button>
              </div>
            </form>
  
            <!-- Tabela -->
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Descrição</th>
                  <th>Data</th>
                  <th>Valor</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="despesa in despesasFiltradas" :key="despesa.id">
                  <td>{{ despesa.id }}</td>
                  <td>{{ despesa.descricao }}</td>
                  <td>{{ formatDate(despesa.data_recebimento) }}</td>
                  <td>R$ {{ formatCurrency(despesa.valor) }}</td>
                  <td>
                    <span
                      :class="{
                        'badge bg-success': despesa.status === 1,
                        'badge bg-danger': despesa.status !== 1
                      }"
                    >
                      {{ despesa.status === 1 ? 'Pago' : 'Não Pago' }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
  
            <!-- Total -->
            <div class="mt-3 text-end">
              <h5>
                <strong>Total:</strong> R$ {{ formatCurrency(totalDespesas) }}
              </h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import moment from "moment";
  import TopoComponent from "@/components/TopoComponent.vue";
  import SidebarComponent from "@/components/SidebarComponent.vue";
  
  export default {
    components: {
      TopoComponent,
      SidebarComponent,
    },
    data() {
      return {
        despesas: [],
        filters: {
          startDate: "",
          endDate: "",
        },
      };
    },
    computed: {
      despesasFiltradas() {
        return this.despesas.filter((despesa) => {
          const dataRecebimento = moment(despesa.data_recebimento);
          const startDate = moment(this.filters.startDate);
          const endDate = moment(this.filters.endDate);
  
          return (
            (!this.filters.startDate || dataRecebimento.isSameOrAfter(startDate)) &&
            (!this.filters.endDate || dataRecebimento.isSameOrBefore(endDate))
          );
        });
      },
      totalDespesas() {
        return this.despesasFiltradas.reduce((total, despesa) => total + despesa.valor, 0);
      },
    },
    methods: {
      async fetchDespesas() {
        try {
          const response = await fetch("http://127.0.0.1:8000/api/indexDespesas");
          const result = await response.json();
          this.despesas = result.data;
        } catch (error) {
          console.error("Erro ao buscar despesas:", error);
        }
      },
      filterDespesas() {
        console.log("Filtrando despesas...");
        // Você pode adicionar lógica de filtragem aqui, se necessário.
      },
      printPage() {
        window.print();
      },
      formatDate(date) {
        return moment(date).format("DD/MM/YYYY");
      },
      formatCurrency(value) {
        return value.toLocaleString("pt-BR", {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2,
        });
      },
    },
    async mounted() {
      await this.fetchDespesas();
    },
  };
  </script>
  
  <style>
  /* Estilos adicionais (se necessário) */
  </style>
  