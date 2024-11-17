import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import MahasiswaView from '@/views/MahasiswaView.vue'
import ProdiView from '@/views/ProdiView.vue'
import PenilaianView from '../views/PenilaianView.vue'
import Swal from 'sweetalert2'
import MatkulView from '@/views/MatkulView.vue'
// const router = createRouter({
//   history: createWebHistory(import.meta.env.BASE_URL),
//   routes: [
//     {
//       path: '/home',
//       name: 'home',
//       component: HomeView,
//     },
//     {
//       path:'/login',
//       name:'login',
//       component: () => import('../views/LoginView.vue')
//     },
//     {
//       path: '/about',
//       name: 'about',
//       // route level code-splitting
//       // this generates a separate chunk (About.[hash].js) for this route
//       // which is lazy-loaded when the route is visited.
//       component: () => import('../views/AboutView.vue'),
//     },
//     {
//       path: '/mahasiswa',
//       name: 'mahasiswa',
//       component: () => import('../views/MahasiswaView.vue'),
//     },
//     {
//       path: '/prodi',
//       name: 'prodi',
//       component: () => import('../views/ProdiView.vue'),
//     },
//     {
//       path: '/matkul',
//       name: 'matkul',
//       component: () => import('../views/MatkulView.vue'),
//     },
//     {
//       path: '/penilaian',
//       name: 'penilaian',
//       component: () => import('../views/PenilaianView.vue'),
//     },
//   ],
// })

const routes = [
  {
    path: '/home',
    name: 'home',
    component: HomeView,
  },
  {
    path:'/login',
    name:'login',
    component: LoginView
  },
  {
    path: '/mahasiswa',
    name: 'mahasiswa',
    component: MahasiswaView,
  },
  {
    path: '/prodi',
    name: 'prodi',
    component: ProdiView,
  },
  {
    path: '/matkul',
    name: 'matkul',
    component: MatkulView,
  },
  {
    path: '/penilaian',
    name: 'penilaian',
    component: PenilaianView,
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  
  if (to.name !== 'login' && !token) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Please Login First!",
      showConfirmButton: false,
      timer: 1000
    }).then(() => {
      next({ name: 'login' });
    })
  } else {
    next();
  }
})
export default router
