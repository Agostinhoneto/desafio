<template>
    <div>
      <canvas id="line-chart"></canvas>
    </div>
  </template>
  
  <script>
  import { Line } from 'vue-chartjs';
  
  export default {
    extends: Line,
    props: ['chartData'],
    mounted() {
      this.renderChart(this.chartData, { responsive: true, maintainAspectRatio: false });
    },
  };
  </script>
  