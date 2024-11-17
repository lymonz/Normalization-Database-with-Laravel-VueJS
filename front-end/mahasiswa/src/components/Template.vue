<script setup>
import Header from '../components/Header.vue'
</script>

<template lang="">
   <Header v-if="$route.name != 'login'" />
</template>

<style lang="">
    
</style>