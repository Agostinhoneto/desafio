import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import UsuariosListVue from '../views/usuarios/UsuariosListVue.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/usuarios',
      component: UsuariosListVue
    },
    {
      path: '/usuarios/id',
      name: 'user-todo',
      component: () => import('../views/AboutView.vue')
    }
  ]
})

export default router
