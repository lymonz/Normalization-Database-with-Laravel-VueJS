<script setup>
import router from "../router";
import ModalAdd from "../components/Prodi/ModalAdd.vue";
import ModalEdit from "../components/Prodi/ModalEdit.vue";
import ModalDelete from "../components/Prodi/ModalDelete.vue";
import axios from "axios";
import Swal from "sweetalert2";
</script>
<template lang="">
  <div class="container mt-4">
    <div class="row g-4">
      <div class="col-md-12">
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
              <h5 class="card-title fs-4 fw-bold">Daftar Program Studi</h5>
              <button class="btn btn-primary" @click="showModal">
                Tambah Program Studi
              </button>
            </div>
            <div v-if="loading" class="text-center">
              <p>Loading...</p>
            </div>
            <div v-else class="table-responsive">
              <table class="table table-hover table-striped" id="prodiTable">
                <thead>
                  <tr>
                    <th scope="col" class="fw-bold">No</th>
                    <th scope="col" class="fw-bold">Program Studi</th>
                    <th scope="col" class="fw-bold">Jurusan</th>
                    <th scope="col" class="fw-bold text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(data, index) in prodiList" :key="data.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ data.prodi }}</td>
                    <td>{{ data.jurusan }}</td>
                    <td>
                      <div class="d-flex justify-content-center">
                        <button
                          class="btn btn-success me-2"
                          @click="showModalEdit(data.id)"
                        >
                          <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-danger" @click="showConfirmDelete(data.id)">
                          <i class="bi bi-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div v-if="error" class="alert alert-danger mt-3">
                {{ error }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <ModalAdd @add-prodi="handleAddProdi" />
  <ModalEdit :prodiData="prodiToEdit" @edit-prodi="handleEditProdi" />
  <!-- <ModalDelete :prodiToDelete="prodiToDelete" @delete-prodi="handleDeleteProdi" /> -->
</template>
<script>
export default {
  components: { ModalAdd, ModalEdit },
  data() {
    return {
      prodiList: [],
      loading: false,
      error: null,
      prodiToEdit: [],
      prodiToDelete: [],
    };
  },
  mounted() {
    this.username = localStorage.getItem("token");
    if (!this.username || this.username == "") {
      router.push({ name: "login" });
    }

    this.getProdi();
  },
  methods: {
    async getProdi() {
      this.loading = true;
      this.error = null;

      try {
        const token = localStorage.getItem("token");

        const response = await axios.get(
          "http://localhost:8000/api/index/prodi",
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );
        this.prodiList = response.data.data;
      } catch (error) {
        console.log(error);
        this.error = "Gagal memuat data program studi.";
      } finally {
        this.loading = false;
        this.$nextTick(() => {
          $("#prodiTable").DataTable({
            paging: true,
            searching: true,
            ordering: true,
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50, 100],
            responsive: true,
            destroy: true,
          });
        });
      }
    },
    showModal() {
      const modal = new bootstrap.Modal(
        document.getElementById("addProdiModal")
      );
      modal.show();
    },
    async showModalEdit(id) {
      try {
        const token = localStorage.getItem("token");
        const response = await axios.get(
          `http://localhost:8000/api/index/prodi/${id}`,
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );
        this.prodiToEdit = response.data.data;
        const modal = new bootstrap.Modal(
          document.getElementById("editProdiModal")
        );
        modal.show();

      } catch (error) {
        console.log(error);
      }
    },
    async showConfirmDelete(id) {
        try {
            const token = localStorage.getItem("token");
            const response = await axios.get(
            `http://localhost:8000/api/index/prodi/${id}`,
            {
                headers: {
                Authorization: `Bearer ${token}`,
                },
            }
            );
            this.prodiToDelete = response.data.data;
            
            this.$swal.fire({
                title: 'Yakin ingin menghapus?',
                text: `Program Studi ${this.prodiToDelete.prodi} akan dihapus secara permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.handleDeleteProdi(id);
                }
            })
        } catch (error) {
            console.log(error);
        }
        
    },
    async handleAddProdi(storeData) {
      this.prodiList.push(storeData);
      try {
        const token = localStorage.getItem("token");
        const response = await axios.post(
          "http://localhost:8000/api/index/prodi/store",
          storeData,
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        console.log("Data program studi berhasil ditambahkan:");
      } catch (error) {
        console.error(
          "Terjadi kesalahan saat menambahkan program studi:",
          error
        );
      }
      // console.log("Data Prodi Berhasil Ditambah:", storeData);
    },
    handleEditProdi(updateData) {
      const token = localStorage.getItem("token");
      if (token) {
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
      }
      axios
        .put(
          `http://localhost:8000/api/index/prodi/update/${updateData.id}`,
          updateData
        )
        .then((response) => {
          const index = this.prodiList.findIndex(
            (prodi) => prodi.id === updateData.id
          );
          if (index !== -1) {
            this.prodiList[index] = { ...updateData };
          }
          const modal = new bootstrap.Modal(
            document.getElementById("editProdiModal")
          );
          modal.hide();

          this.$swal({
            position: "center",
            icon: "success",
            title: "Data berhasil diperbarui",
            showConfirmButton: false,
            timer: 1500,
          });
        })
        .catch((error) => {
          console.error("Error updating data:", error);
        });
    },

    handleDeleteProdi(id) {
        const token = localStorage.getItem("token");
        if (token) {
            axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        }
        axios.delete(`http://localhost:8000/api/index/prodi/destroy/${id}`)
        .then(() => {
            const index = this.prodiList.findIndex((prodi) => prodi.id === id);
            if (index !== -1) {
            this.prodiList.splice(index, 1);
            }
            this.$swal({
            position: "center",
            icon: "success",
            title: "Data berhasil dihapus",
            showConfirmButton: false,
            timer: 1500,
            }).then(() => {
                window.location.reload();
            });
        })
        .catch((error) => {
            console.error("Error deleting data:", error);
        });
    },
    showError() {
            Swal.fire({
                position: "center",
                icon: "error",
                title: this.errorMessage,
                showConfirmButton: false,
                timer: 1500
            });
        } 
  },
};
</script>
<style lang=""></style>
