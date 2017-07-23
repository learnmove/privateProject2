<template>
  <div id="app">
    <div class="container">
    <nav-bar></nav-bar>
    <router-view></router-view>

    </div>
    <div>
  <router-link :to="{name:'chat'}" tag="button" class="chat btn btn-danger"><span class="badge">5</span>聊聊</router-link>
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

<style scoped="true">
.chat{
  position: fixed;
  bottom:5px;
  right:0px;
}
</style>
