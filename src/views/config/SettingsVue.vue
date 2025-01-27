<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Configurações</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Configurações de Controle de Gastos</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form @submit.prevent="saveSettings">
            <div class="card-body">
              <div class="form-group">
                <label for="categoria">Categoria</label>
                <input type="text" class="form-control" id="categoria" v-model="settings.categoria" placeholder="Insira a categoria">
              </div>
              <div class="form-group">
                <label for="orcamento">Orçamento</label>
                <input type="number" class="form-control" id="orcamento" v-model="settings.orcamento" placeholder="Insira o orçamento">
              </div>
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="notificacoes" v-model="settings.notificacoes">
                <label class="form-check-label" for="notificacoes">Notificações</label>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      settings: {
        categoria: '',
        orcamento: 0,
        notificacoes: false
      }
    };
  },
  methods: {
    saveSettings() {
      console.log('Configurações salvas:', this.settings);
      // Aqui você pode adicionar o código para salvar as configurações, por exemplo, enviando para um servidor
    }
  }
};
</script>

<style scoped>
/* Adicione seu estilo aqui */
</style>