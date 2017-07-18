import Vue from 'vue'
const types={
get_item_rating:'get_item_rating'
}
const ratings={
    namespaced: true,
    state:{
        items:[],
        pages:{}
    },
    mutations:{
        [types.get_item_rating](state,data){
            state.items=data.data
            delete data['data']
            state.pages=data
        }
    },
    actions:{
        get_item_rating({commit},{user_account,page,method_name}){
            
             Vue.axios.get(`/rating/${user_account}?page=${page}&method_name=${method_name}`)
            .then(({data})=>{
                commit(types.get_item_rating,data)
            })
        },
      
    },
    getters:{
    
    }
}
export default ratings