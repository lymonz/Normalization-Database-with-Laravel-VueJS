import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import axios from 'axios';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Swal from 'sweetalert2';


const token = localStorage.getItem('token');

if (token) {
  axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.config.globalProperties.$axios = axios;
const options = {
    confirmButtonColor: '#41b882',
    cancelButtonColor: '#ff7674',
};
app.use(createPinia())
app.use(router)
app.use(VueSweetalert2, options);
app.mount('#app')
