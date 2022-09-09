import Vue from 'vue'
const types={
    set_products:'set_products',
    set_product: 'set_product',
    set_recommand_products: 'set_recommand_products',
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
          store_info:{},
          product: {name:'', category:{name:''}, school:{name:''},user:{account: ''}},
          recommand_products: [],
        },
     mutations: { 
         [types.set_products](state,data){
            state.products = data;
         },
         [types.set_product](state,data){
            state.product = data;
         },
         [types.set_recommand_products](state,data){
            state.recommand_products = data;
         },
         [types.delete_product](state,data){
             state.products.data=state.products.data.filter((item)=>{
                 return item !== data;
             })
         },
         [types.edit_product](state,data){
            state.edit_product=data
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
            console.log('2')
            Vue.axios.get(`/product?page=${page}&method_name=${method_name}&selectSchoolID=${selectSchoolID}&category_id=${category_id}&keyword=${keyword}`)
            .then(({data})=>{
                commit(types.set_products,data)
            })
        },
        
        fetchProduct({commit,state, dispatch},id){
            Vue.axios.get(`/product/${id}`).then(({data})=>{
                commit(types.set_product, data)
                dispatch('fetchRecommandProducts', state.product.user.id)
                
            })
        },
        fetchRecommandProducts({commit}, user_id){
            Vue.axios.get(`/fetchRecommandProducts?user_id=${user_id}`).then(({data})=>{
                commit(types.set_recommand_products, data)
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
                console.log(data)
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