import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import UsuariosCadVue from '../views/usuarios/UsuariosCadVue.vue'
import UsuariosUpdate from '../views/usuarios/UsuariosUpdate.vue'
import Dashboard from '../components/Dashboard.vue'
//import Dashboard from '@/components/Dashboard.vue'; // ou o caminho correto para o seu arquivo Dashboard.vue
import Enderecos from '../views/Enderecos.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
   
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/dashboard',
      name: 'Dashboard',
      component: Dashboard,
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
    },
    {
      path: '/enderecos',
      name: 'user-enderecos',
      component: () => import('../views/Enderecos.vue')
    }
  ]
})

export default router
