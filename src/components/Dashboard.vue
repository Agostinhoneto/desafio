<template>
    <div class="dashboard">
      <h1>Dashboard</h1>
      <div class="cards">
        <div class="card">
          <h3>Total de Usuários</h3>
          <p>{{ totalUsers }}</p>
        </div>
        <div class="card">
          <h3>Novos Usuários</h3>
          <p>{{ newUsers }}</p>
        </div>
      </div>
      <div class="charts">
        <line-chart :chart-data="userGrowthData" />
        <bar-chart :chart-data="userActivityData" />
      </div>
    </div>
  </template>
  
  <script>
  import LineChart from './LineChart.vue';
  import BarChart from './BarChart.vue';
  
  export default {
    components: {
      LineChart,
      BarChart,
    },
    data() {
      return {
        totalUsers: 1500,
        newUsers: 100,
        userGrowthData: {
          labels: ['January', 'February', 'March', 'April', 'May'],
          datasets: [
            {
              label: 'User Growth',
              backgroundColor: '#f87979',
              data: [40, 20, 12, 39, 10, 40],
            },
          ],
        },
        userActivityData: {
          labels: ['Login', 'Signup', 'Purchase', 'Logout', 'View'],
          datasets: [
            {
              label: 'User Activity',
              backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16', '#C0C0C0'],
              data: [100, 50, 25, 75, 90],
            },
          ],
        },
      };
    },
  };
  </script>
  
  <style scoped>
  .dashboard {
    padding: 20px;
  }
  .cards {
    display: flex;
    justify-content: space-between;
  }
  .card {
    background-color: #f4f4f4;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    flex: 1;
    margin: 10px;
  }
  .charts {
    display: flex;
    justify-content: space-around;
    margin-top: 40px;
  }
  </style>
  