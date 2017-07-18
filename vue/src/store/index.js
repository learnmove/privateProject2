
import Vue from 'vue'
import Vuex from 'vuex'
import products from './product/index'
import cart from './cart/index'
import ratings from './ratings/index'
Vue.use(Vuex);

 const store=new Vuex.Store({
    state:{
        count:0
    },
    mutations:{
        increment(state){
            state.count++
        }
    },
    modules:{
        products,
        cart,
        ratings
    }

})
export default store