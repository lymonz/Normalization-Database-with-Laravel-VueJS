<script setup>
import { useRouter } from 'vue-router';  // Import useRouter dari vue-router
import Swal from 'sweetalert2';   

// Mengakses router
const router = useRouter();

// Cek token di localStorage
const token = localStorage.getItem('token');

// Jika token tidak ada, alihkan ke halaman login
if (!token) {
  Swal.fire({
    position: "center",
    icon: "error",
    title: "Please Login First!",
    showConfirmButton: false,
    timer: 1500
  }).then(() => {
    router.push({ name: 'login' });
  })
}
</script>

<template>
  <div class="container mt-4">
    <div class="row g-4">

      <div class="col-md-4" v-for="prodi in prodiList" :key="prodi.id">
        <div class="card shadow-sm">
          <div class="card-body text-center">
            <h5 class="card-title">{{ prodi.name }}</h5>
            <p class="card-text fs-4 fw-bold text-primary">{{ prodi.count }}</p>
            <p class="text-muted">Jumlah Mahasiswa</p>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</template>

<script>
export default {
    data() {
      return {
        prodiList: [
          { id: 1, name: "Teknik Informatika", count: 120 },
          { id: 2, name: "Sistem Informasi", count: 85 },
          { id: 3, name: "Teknik Komputer", count: 60 },
        ],
      };
    },
    // mounted() {
    //     this.token = localStorage.getItem('token')
    //     if(!this.token || this.username == ''|| this.token == null){
    //         router.push({name:'login'});
    //     }
    // },   
}
</script>