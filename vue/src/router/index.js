import Vue from 'vue'
import Router from 'vue-router'
import Hello from '@/components/Hello'
import Login from '@/components/auth/Login'
import Signup from '@/components/auth/Signup'
import School from '@/components/auth/School'
import product from './product'
import chat from './chat'
Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'hello',
      redirect:{name:'product'}
    },
    // {
    //   path:'/member'
    // },

    {
      path:'/login',
      name:'login',
      component:Login,
      meta:{
        forVisitors:true
      }
    },
    {
      path:'/signup',
      name:'signup',
      component:Signup,
      meta:{
        forVisitors:true
      }
    },
    {
      path:'/change_school',
      name:'change_school',
      component: School,
     meta:{forAuth:true}
      
    },
    ...product
    ,    
    ...chat
  
  ]
})
