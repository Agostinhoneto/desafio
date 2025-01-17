<script setup>
import { RouterLink, RouterView } from 'vue-router'
import NavBar from './components/NavBar.vue';
import Dashboard from './components/Dashboard.vue';
import MenuLateral  from './components/MenuLateral.vue';

</script>

<template>
  <div class="container">
    <RouterView />
  </div>
  <MenuLateral />
</template>

<style>
</style>
