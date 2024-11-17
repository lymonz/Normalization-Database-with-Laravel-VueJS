<script setup>
import { RouterLink, RouterView } from 'vue-router'
import Template from './components/Template.vue'
import axios from 'axios';
import Swal from 'sweetalert2';
</script>

<template>
  <Template />

  <RouterView />
</template>

<script>
export default {
  data() {
    return {
        name : localStorage.getItem('name'),
        name : localStorage.getItem('token'),
    }
  }
}
</script>

<style scoped>

</style>
