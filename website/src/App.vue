<script setup>
// This starter template is using Vue 3 <script setup> SFCs
// Check out https://v3.vuejs.org/api/sfc-script-setup.html#sfc-script-setup
import Footer from './components/Footer.vue'

</script>

<template>
  <div class="container mt-8 mx-auto pd-4 mt-6 space-y-4 pt-8">
    <router-view></router-view>
  </div>
  <Footer />
</template>

<style>
#app {
  text-align: center;
  /* margin-top: 10%; */
}
</style>
