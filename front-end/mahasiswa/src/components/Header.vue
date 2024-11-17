<template lang="">
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"
        ><span class="logo-text text-white">Penilaian</span
        ><span class="logo-text text-info">Mahasiswa</span></a
      >
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link
              to="/home"
              class="nav-link"
              :class="{ active: $route.path === '/home' }"
              aria-current="page"
              >Home
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              to="/mahasiswa"
              class="nav-link"
              :class="{ active: $route.path === '/mahasiswa' }"
              aria-current="page"
              >Data Mahasiswa
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              to="/prodi"
              class="nav-link"
              :class="{ active: $route.path === '/prodi' }"
              aria-current="page"
              >Program Studi
            </router-link>
          </li>

          <li class="nav-item">
            <router-link
              to="/matkul"
              class="nav-link"
              :class="{ active: $route.path === '/matkul' }"
              aria-current="page"
              >Mata Kuliah
            </router-link>
          </li>

          <li class="nav-item">
            <router-link
              to="/penilaian"
              class="nav-link"
              :class="{ active: $route.path === '/penilaian' }"
              aria-current="page"
              >Penilaian
            </router-link>
          </li>
        </ul>
        <li class="nav-item d-flex justify-content-" @click="toggleLogoutMenu">
          <div class="user-icon">
            <i class="bi bi-person-circle text-white"></i>
          </div>
          <div>
            <span class="nav-link user-text">{{ name }}</span>
          </div>
        </li>

        <!-- Tampilkan tombol logout jika toggleLogoutMenu diaktifkan -->
        <div v-if="showLogoutMenu" class="logout-menu mt-2">
          <button class="btn btn-danger w-100" @click="logout">Logout</button>
        </div>
      </div>
    </div>
  </nav>
</template>
<script>
import Swal from "sweetalert2";
export default {
  data() {
    return {
      name: localStorage.getItem("name"),
      showLogoutMenu: false,
    };
  },
  methods: {
    toggleLogoutMenu() {
      // Toggle untuk menunjukkan atau menyembunyikan menu logout
      this.showLogoutMenu = !this.showLogoutMenu;
    },
    logout() {
      // Hapus token dan data user dari localStorage
      localStorage.removeItem("token");
      localStorage.removeItem("name");
      localStorage.removeItem("email");
    
      Swal.fire({
        icon: "success",
        title: "Logout Berhasil",
        text: "Anda telah berhasil logout.",
        showConfirmButton: false,
        timer: 1500
      }).then(() => {
          this.$router.push("/login");          
      })
    },
  },
};
</script>
<style scoped>
.nav-link.active {
  background-color: #007bff; /* Warna latar belakang saat aktif */
  color: white; /* Warna teks saat aktif */
  font-weight: bold; /* Menebalkan teks saat aktif */
  border-radius: 5px;
}
.logout-menu {
  position: absolute;
  top: 100%;
  right: 0;
  width: 200px;
  background-color: white;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
  padding: 10px;
  z-index: 999;
}
.user-icon {
  padding: 5px;
}
.user-text {
  padding: 5px;
  color: #000;
  font-weight: normal;
  text-decoration: none;
  cursor: pointer;
}

.user-text:hover {
    border-radius: 15px;
  color: #007bff;
  background: rgba(50, 105, 255, 0.1);
}

.navbar {
  background: linear-gradient(
    90deg,
    rgba(2, 0, 36, 1) 0%,
    rgba(9, 9, 121, 1) 0%,
    rgba(0, 212, 255, 1) 100%
  );
}

.nav-link {
  font-size: 16px;
  font-family: "K2D", sans-serif;
  font-weight: 600;
  color: white;
}

.nav-link:hover {
  color: red;
}

@media (max-width: 768px) {
  .nav-link {
    color: #fff;
  }
}
</style>
