<template>
  <div id="app">
    <div class="container">
    <nav-bar></nav-bar>
    <router-view></router-view>

    </div>
  </div>
</template>

<script>
import Navbar from'@/components/Navbar'
export default {
  name: 'app',
  components:{
    'nav-bar':Navbar
  }
}
</script>

<style>

</style>
