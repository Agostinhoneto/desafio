import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import UsuariosCadVue from '../views/usuarios/UsuariosCadVue.vue'
import UsuariosUpdate from '../views/usuarios/UsuariosUpdate.vue'
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
      name: 'cad-usuarios',
      component: UsuariosCadVue
    },
    {
      path: '/usuarios-update',
      name: 'update-usuarios',
      component: UsuariosUpdate
    },
    {
      path: '/usuarios/id',
      name: 'user-todo',
      component: () => import('../views/AboutView.vue')
    }
  ]
})

export default router
