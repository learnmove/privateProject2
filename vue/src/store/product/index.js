import Vue from 'vue'
const types={
    set_products:'set_products',
    delete_product:'delete_product',
    edit_product:'edit_product'
}
const products={
    namespaced: true,
     state:{
          products:{},
          edit_product:{}
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
            

        }
        

   },
   getters:{
     getProducts(state){return state.products},
 
     
          
     
   }
}
export default  products