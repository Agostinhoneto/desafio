<template>
  <div class="content-wrapper">
  <!-- Cabeçalho da Página -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h4 class="m-0">Painel de Controle</h4>
        </div>
      </div>
    </div>
  </div>
  <!-- /Cabeçalho da Página -->

  <!-- Conteúdo Principal -->
  <section class="content">
    <div class="container-fluid">
      <!-- Cartões de Destaque -->
      <div class="row">
        <!-- Receita -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>0</h3>
              <p>Receitas Registradas</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="/receitas" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- Despesa -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>0</h3>
              <p>Despesas Registradas</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="/despesas" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- Usuários -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>0</h3>
              <p>Usuários Registrados</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/usuarios" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- Finanças -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>0%</h3>
              <p>Minhas Finanças</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="/financas" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <!-- /Cartões de Destaque -->

      <!-- Gráficos e Widgets -->
      <div class="row">
        <!-- Gráficos -->
        <section class="col-lg-7 connectedSortable">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Balanços
              </h3>
              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item">
                    <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Área</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#sales-chart" data-toggle="tab">Pizza</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="card-body">
              <div class="tab-content p-0">
                <div class="chart tab-pane active" id="revenue-chart" style="height: 300px;">
                  <canvas id="revenue-chart-canvas" height="300"></canvas>
                </div>
                <div class="chart tab-pane" id="sales-chart" style="height: 300px;">
                  <canvas id="sales-chart-canvas" height="300"></canvas>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Visitantes e Calendário -->
        <section class="col-lg-5 connectedSortable">
          <!-- Visitantes -->
          <div class="card bg-gradient-primary">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-map-marker-alt mr-1"></i>
                Visitantes
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm daterange" title="Intervalo de Datas">
                  <i class="far fa-calendar-alt"></i>
                </button>
                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div id="world-map" style="height: 250px; width: 100%;"></div>
            </div>
          </div>

          <!-- Calendário -->
          <div class="card bg-gradient-success">
            <div class="card-header">
              <h3 class="card-title">
                <i class="far fa-calendar-alt"></i>
                Calendário
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                  <i class="fas fa-bars"></i>
                </button>
                <div class="dropdown-menu" role="menu">
                  <a href="#" class="dropdown-item">Adicionar Evento</a>
                  <a href="#" class="dropdown-item">Limpar Eventos</a>
                </div>
                <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div id="calendar" style="width: 100%;"></div>
            </div>
          </div>
        </section>
      </div>
      <!-- /Gráficos e Widgets -->
    </div>
  </section>
  <!-- /Conteúdo Principal -->
</div>
</template>
