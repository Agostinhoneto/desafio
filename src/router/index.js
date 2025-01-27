import { createRouter, createWebHistory } from 'vue-router';

import LoginView from '../views/LoginView.vue';
import Dashboard from '../components/Dashboard.vue';
//Usuários
import UsuariosListVue from '../views/usuarios/UsuariosListVue.vue';
import UsuariosCadVue from '../views/usuarios/UsuariosCadVue.vue';
import UsuariosUpdate from '../views/usuarios/UsuariosUpdate.vue';
//Receitas
import ReceitasCadVue from '../views/receitas/ReceitasCadVue.vue';
import ReceitasListVue from '../views/receitas/ReceitasListVue.vue';
//Despesas
import DespesasCadVue from '../views/despesas/DespesasCadVue.vue';
import DespesasListVue from '../views/despesas/DespesasListVue.vue';
//Finanças
import FinancasVue from '../views/financas/FinancasVue.vue';
import RelatoriosVue from '../views/relatorios/RelatoriosVue.vue';
//configurações
import SettingsVue from '../views/config/SettingsVue.vue';

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
    meta: { MenuLateral: 'default' }, 
  },
  {
    path: '/lista-usuarios',
    name: 'lista',
    component: UsuariosListVue,
    meta: { MenuLateral: 'default' }, 
  },
  {
    path: '/usuarios',
    name: 'cad-usuarios',
    component: UsuariosCadVue,
    meta: { MenuLateral: 'default' }, 
  },
  {
    path: '/usuarios-update',
    name: 'update-usuarios',
    component: UsuariosUpdate,
    meta: { MenuLateral: 'default' }, 
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
    meta: { MenuLateral: 'default' }, 
  },
  {
    path: '/receitas-lista',
    name: 'lista-receitas',
    component: ReceitasListVue,
    meta: { MenuLateral: 'default' }, 
  },
  {
    path: '/despesas',
    name: 'cad-despesas',
    component: DespesasCadVue,
    meta: { MenuLateral: 'default' }, 
  },
  {
    path: '/despesas-lista',
    name: 'lista-despesas',
    component: DespesasListVue,
    meta: { MenuLateral: 'default' }, 
  },
  {
    path: '/enderecos',
    name: 'user-enderecos',
    component: () => import('../views/Enderecos.vue'),
    meta: { MenuLateral: 'default' }, 
  },
  {
    path: '/financas',
    name: 'list-financas',
    component: FinancasVue,
    meta: { MenuLateral: 'default' }, 
  },
  {
    path: '/relatorios',
    name: 'list-relatorios',
    component: RelatoriosVue,
    meta: { MenuLateral: 'default' }, 
  },
  {
    path: '/lista-configuracoes',
    name: 'lista-configuracoes',
    component: SettingsVue,
    meta: { MenuLateral: 'default' }, 
  },
  
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

export default router;
