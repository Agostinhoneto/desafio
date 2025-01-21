import { createRouter, createWebHistory } from 'vue-router';
import LoginView from '../views/LoginView.vue';
import Dashboard from '../components/Dashboard.vue';
import UsuariosListVue from '../views/usuarios/UsuariosListVue.vue';
import UsuariosCadVue from '../views/usuarios/UsuariosCadVue.vue';
import UsuariosUpdate from '../views/usuarios/UsuariosUpdate.vue';
import ReceitasCadVue from '../views/receitas/ReceitasCadVue.vue';
import DespesasCadVue from '../views/despesas/DespesasCadVue.vue';

const routes = [
  {
    path: '/',
    name: 'Login',
    component: LoginView,
    meta: { MenuLateral: 'empty' }, // Não exibir o menu lateral
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard,
    meta: { MenuLateral: 'default' }, // Exibir o menu lateral
  },
  {
    path: '/lista-usuarios',
    name: 'lista',
    component: UsuariosListVue,
    meta: { MenuLateral: 'default' }, // Exibir o menu lateral
  },
  {
    path: '/usuarios',
    name: 'cad-usuarios',
    component: UsuariosCadVue,
    meta: { MenuLateral: 'default' }, // Exibir o menu lateral
  },
  {
    path: '/usuarios-update',
    name: 'update-usuarios',
    component: UsuariosUpdate,
    meta: { MenuLateral: 'default' }, // Exibir o menu lateral
  },
  {
    path: '/usuarios/id',
    name: 'user-todo',
    component: () => import('../views/AboutView.vue')
  },
  {
    path: '/receitas',
    name: 'cad-receitas',
    component: ReceitasCadVue,
    meta: { MenuLateral: 'default' }, // Exibir o menu lateral
  },
  {
    path: '/despesas',
    name: 'cad-despesas',
    component: DespesasCadVue,
    meta: { MenuLateral: 'default' }, // Exibir o menu lateral
  },
  {
    path: '/enderecos',
    name: 'user-enderecos',
    component: () => import('../views/Enderecos.vue'),
    meta: { MenuLateral: 'default' }, // Exibir o menu lateral
  }
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

export default router;
