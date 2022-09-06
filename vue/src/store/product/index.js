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
          edit_product:{category_id:''},
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
             let product=data
                state.edit_product=product
                console.log(product)
                state.edit_product.category_id=product.categories[0].id

                // Object.defineProperty(
                //     state.edit_product,
                //     'category_id',
                //     {value:product.categories[0].id})
                 
                
                 
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
      
        fetchProducts({commit},{page,method_name,keyword='',selectSchoolID,category_id=''}){
            Vue.axios.get(`/product?page=${page}&method_name=${method_name}&selectSchoolID=${selectSchoolID}&category_id=${category_id}&keyword=${keyword}`)
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
        fetchMyProducts({commit},{page,method_name}){
            Vue.axios.get(`/mystore?page=${page}&method_name=${method_name}`)
            .then(({data})=>{
                commit(types.fetchMyProducts,data)
            })
        },
        fetchUserProducts({commit},{user_account,pagination}){
            Vue.axios.get(`/userstore/${user_account}?page=${pagination.page}`)
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