<script setup>
import axios from "axios";
import ModalAdd from "../components/Matkul/ModalAdd.vue";
import ModalEdit from "../components/Matkul/ModalEdit.vue";
</script>
<template lang="">
    <div class="container mt-4">
    <div class="row g-4">
      <div class="col-md-12">
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
              <h5 class="card-title fs-4 fw-bold">Daftar Mata Kuliah</h5>
              <button class="btn btn-primary" @click="showModal">
                Tambah Mata Kuliah
              </button>
            </div>
            <div v-if="loading" class="text-center">
              <p>Loading...</p>
            </div>
            <div v-else class="table-responsive">
              <table class="table table-hover table-striped" id="matkulTable">
                <thead>
                  <tr>
                    <th scope="col" class="fw-bold">No</th>
                    <th scope="col" class="fw-bold">Kode Mata Kuliah</th>
                    <th scope="col" class="fw-bold">Mata Kuliah</th>
                    <th scope="col" class="fw-bold">SKS</th>
                    <th scope="col" class="fw-bold text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(data, index) in matkulList" :key="data.kode_matkul">
                    <td>{{ index + 1 }}</td>
                    <td>{{ data.kode_matkul }}</td>
                    <td>{{ data.mata_kuliah }}</td>
                    <td>{{ data.sks }}</td>
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

  <ModalAdd @add-matkul="handleAddMatkul" />
  <ModalEdit :matkulData="matkulToEdit" @edit-matkul="handleEditMatkul" />
</template>
<script>
export default {
  components: { ModalAdd, ModalEdit },
  data() {
    return {
      matkulList: [],
      loading: false,
      error: null,
      matkulToEdit: [],
      matkulToDelete: [],
    };
  },
  mounted() {
    this.getMatkul();
  },
  methods: {
    async getMatkul() {
      this.loading = true;
      this.error = null;

      try {
        const token = localStorage.getItem("token");

        const response = await axios.get(
          "http://localhost:8000/api/index/matkul",
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );
        this.matkulList = response.data.data;
      } catch (error) {
        console.log(error);
        this.error = "Gagal memuat data mata kuliah.";
      } finally {
        this.loading = false;
        this.$nextTick(() => {
          $("#matkulTable").DataTable({
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
        document.getElementById("addMatkulModal")
      );
      modal.show();
    },
    async showModalEdit(id) {
      try {
        const token = localStorage.getItem("token");
        const response = await axios.get(
          `http://localhost:8000/api/index/matkul/${id}`,
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );
        this.matkulToEdit = response.data[0];
        // console.log(response.data[0])
        const modal = new bootstrap.Modal(
          document.getElementById("editMatkulModal")
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
            `http://localhost:8000/api/index/matkul/${id}`,
            {
                headers: {
                Authorization: `Bearer ${token}`,
                },
            }
            );
            this.matkulToDelete = response.data[0];
            this.$swal.fire({
                title: 'Yakin ingin menghapus?',
                text: `Program Studi ${this.matkulToDelete.mata_kuliah} akan dihapus secara permanen!`,
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
    async handleAddMatkul(storeData) {
      this.matkulList.push(storeData);
      try {
        const token = localStorage.getItem("token");
        const response = await axios.post(
          "http://localhost:8000/api/index/matkul/store",
          storeData,
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        console.log("Data Mata Kuliah berhasil ditambahkan:");
      } catch (error) {
        console.error(
          "Terjadi kesalahan saat menambahkan program studi:",
          error
        );
      }
      // console.log("Data Prodi Berhasil Ditambah:", storeData);
    },
    handleEditMatkul(updateData) {
      const token = localStorage.getItem("token");
      if (token) {
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
      }
      axios
        .put(
          `http://localhost:8000/api/index/matkul/update/${updateData.id}`,
          updateData
        )
        .then((response) => {
          const index = this.matkulList.findIndex(
            (kode_matkul) => kode_matkul.id === updateData.id
          );

          if (index !== -1) {
            this.matkulList[index] = { ...updateData };
          }
          const modal = new bootstrap.Modal(
            document.getElementById("editMatkulModal")
          );
          modal.hide();

          this.$swal({
            position: "center",
            icon: "success",
            title: "Data berhasil diperbarui",
            showConfirmButton: false,
            timer: 1500,
          }).then(() => {
              window.location.reload();
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
        axios.delete(`http://localhost:8000/api/index/matkul/destroy/${id}`)
        .then(() => {
            const index = this.matkulList.findIndex((mata_kuliah) => mata_kuliah.id === id);
            if (index !== -1) {
            this.matkulList.splice(index, 1);
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
    }
  },
};
</script>
<style lang="">
    
</style>