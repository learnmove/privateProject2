import Vue from 'vue'
const types={
    set_products:'set_products',
    delete_product:'delete_product',
    edit_product:'edit_product',
    fetchMyProducts:'fetchMyProducts',
    fetchUserProducts:'fetchUserProducts',
    filter_sellout:'filter_sellout',
    set_store_info:'set_store_info'
}
const products={
    namespaced: true,
     state:{
          products:[],
          edit_product:{},
          store_info:{}
        },
     mutations: { 
         [types.set_products](state,data){
            state.products=data
         },
         [types.delete_product](state,data){
             state.products.data=state.products.data.filter((item)=>{
                 return item!==data
             })
         },
         [types.edit_product](state,data){
            state.edit_product=data
         },
         [types.fetchMyProducts](state,data){
            state.products=data
         },
         [types.fetchUserProducts](state,data){
             state.products=data
         },
         [types.set_store_info](state,data){
             state.store_info=data
         }
   },
     actions: { 
      
        fetchProducts({commit},page){
            Vue.axios.get(`/product?page=${page}`)
            .then(({data})=>{
                commit(types.set_products,data)
            })
        },
        deleteProduct({commit},product){
               Vue.axios.delete(`/product/${product.id}`)
            .then(({data})=>{
                commit(types.delete_product,product)
            })
        },
        editProduct({commit},source){
               Vue.axios.get(source)
            .then(({data})=>{
                commit(types.edit_product,data)
            })
            

        },
        fetchMyProducts({commit},page){
            Vue.axios.get(`/mystore?page=${page}`)
            .then(({data})=>{
                commit(types.fetchMyProducts,data)
            })
        },
        fetchUserProducts({commit},data){
            Vue.axios.get(`/userstore/${data.user_account}?page=${data.page}`)
          .then(({data})=>{
              
         commit(types.fetchUserProducts,data.model)
         commit(types.set_store_info,data.store_info)

             })
        }
     }
   ,
   getters:{
     getProducts(state){return state.products},
    filter_sellout(state){
       let products=state.products.data
  let arr=new Array();
       for(let key in products){
           arr.push(products[key])
       }
        return  arr.filter(item=>item.qty===0)
        // 奇怪的bug 明明products.data也是array


        //  return  products.filter(item=>item.qty===0)
    }
   }
}
export default products