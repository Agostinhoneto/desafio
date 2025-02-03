<!-- Painel de Controle -->
 <template>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">Painel de Controle</h4>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info" onmouseover="mostrarTooltip(event, 'Total de receitas registradas')" onmouseout="ocultarTooltip()">
              <div class="inner">
                <h3 id="receitas" class="positive">0</h3>
                <p>Receitas Registradas</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="/receitas" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger" onmouseover="mostrarTooltip(event, 'Total de despesas registradas')" onmouseout="ocultarTooltip()">
              <div class="inner">
                <h3 id="despesas" class="negative">0</h3>
                <p>Despesas Registradas</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="/despesas" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning" onmouseover="mostrarTooltip(event, 'Total de usuários registrados')" onmouseout="ocultarTooltip()">
              <div class="inner">
                <h3 id="usuarios" class="neutral">0</h3>
                <p>Usuários Registrados</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="/usuarios" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success" onmouseover="mostrarTooltip(event, 'Porcentagem das finanças')" onmouseout="ocultarTooltip()">
              <div class="inner">
                <h3 id="financas" class="positive">0%</h3>
                <p>Minhas Finanças</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="/financas" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
  <!-- Tooltip -->
  <div id="tooltip" style="display: none; position: absolute; background-color: #f9f9f9; border: 1px solid #ccc; padding: 10px; z-index: 1000;"></div>
  
  <script>
    // Função para mostrar o tooltip
    function mostrarTooltip(event, texto) {
      const tooltip = document.getElementById('tooltip');
      tooltip.style.display = 'block';
      tooltip.style.left = event.pageX + 10 + 'px';
      tooltip.style.top = event.pageY + 10 + 'px';
      tooltip.textContent = texto;
    }
  
    // Função para ocultar o tooltip
    function ocultarTooltip() {
      const tooltip = document.getElementById('tooltip');
      tooltip.style.display = 'none';
    }
  
    // Função para buscar dados da API e atualizar o painel
    async function atualizarPainel() {
      try {
        const response = await fetch('URL_DA_SUA_API');
        const dados = await response.json();
  
        // Atualiza os dados
        document.getElementById('receitas').textContent = dados.receitas;
        document.getElementById('despesas').textContent = dados.despesas;
        document.getElementById('usuarios').textContent = dados.usuarios;
        document.getElementById('financas').textContent = dados.financas + '%';
  
        // Define cores com base nas tendências
        definirCores(dados.receitas, 'receitas');
        definirCores(dados.despesas, 'despesas');
        definirCores(dados.financas, 'financas');
      } catch (error) {
        console.error('Erro ao buscar dados da API:', error);
      }
    }
  
    // Função para definir cores com base nas tendências
    function definirCores(valor, elementoId) {
      const elemento = document.getElementById(elementoId);
      if (valor > 0) {
        elemento.classList.add('positive');
        elemento.classList.remove('negative', 'neutral');
      } else if (valor < 0) {
        elemento.classList.add('negative');
        elemento.classList.remove('positive', 'neutral');
      } else {
        elemento.classList.add('neutral');
        elemento.classList.remove('positive', 'negative');
      }
    }
  
    // Atualiza o painel ao carregar a página
    window.onload = atualizarPainel;
  </script>
  
  <style>
    .positive {
      color: green;
    }
    .negative {
      color: red;
    }
    .neutral {
      color: gray;
    }
  </style>
  