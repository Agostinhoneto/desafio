<script setup>
import { RouterView, useRoute } from 'vue-router';
import { computed } from 'vue'; 
import MenuLateral from './components/MenuLateral.vue';

const route = useRoute();

const showMenuLateral = computed(() => route.meta.MenuLateral !== 'empty');
</script>

<template>
  <div class="app-container">
    <!-- Exibir o menu lateral somente se permitido pela rota -->
    <MenuLateral v-if="showMenuLateral" />
    <div class="content-container">
      <RouterView />
    </div>
  </div>
</template>

<style>
.app-container {
  display: flex;
  height: 100vh;
}

.content-container {
  flex: 1;
  overflow: auto;
  padding: 20px;
}
</style>
