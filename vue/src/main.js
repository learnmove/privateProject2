// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import Vuex from 'vuex'
import store from '@/store/index'
import axios from 'axios'
import vueaxios from 'vue-axios'
import VueSweetAlert from 'vue-sweetalert'
import Auth from './components/auth/auth.js'
import VueEcho from 'vue-echo'
const io = window.io = require('socket.io-client');

Vue.use(VueSweetAlert)
Vue.config.productionTip = false
Vue.use(vueaxios,axios)
Vue.use(Auth)
Vue.use(VueEcho,{
    broadcaster: 'socket.io',
  key:'36e77906f0963e755c057cf3bb2cf1da',
  host: 'http://localhost:6001'

})
Vue.axios.defaults.baseURL="http://localhost/laravel/ProductSale/public/api/"
Vue.axios.defaults.headers.common['Authorization']='Bearer '+Vue.auth.getToken()
 router.beforeEach((to, from, next) => {
  if(to.matched.some(record=>record.meta.forVisitors))
  {
      if(Vue.auth.isAuthenticate()){
        next({name:'hello'})
      }else{
        next()
      }
  }else{
    if(to.matched.some(record=>record.meta.forAuth)){
     if(Vue.auth.isAuthenticate()){
        next()
      }else{
        next({name:'hello'})
      }
    }else{
      next()
      
    }
  } 
})

new Vue({
  el: '#app',
  router,
  template: '<App/>',
  store,
  components: { App },
 
})
