import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import moment from 'moment'
import 'admin-lte/dist/css/adminlte.min.css';
import 'admin-lte/dist/js/adminlte.min.js';
import 'bootstrap/dist/css/bootstrap.min.css'; // Dependência do AdminLTE
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '@fortawesome/fontawesome-free/css/all.min.css'; // Font Awesome (opcional)
// Importações AdminLTE
import 'admin-lte/dist/css/adminlte.min.css';
import 'admin-lte/dist/js/adminlte.min.js';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '@fortawesome/fontawesome-free/css/all.min.css';

const app = createApp(App)

app.use(router)

app.mount('#app')
