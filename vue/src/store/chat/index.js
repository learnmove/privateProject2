import Vue from 'vue'
const types={
    getChatlist:'get_chat_list'
}
const chat={
    namespaced: true,
    state:{
        chat_data:{
            chat_user:[]
        },
        chat_message:[]
    },
    mutations:{
        [types.getChatlist](state,data){
            state.chat_data=data
            
                Object.assign(state.chat_data, data)
                 
            
        }
    },
    actions:{
        getChatlist({commit}){
        Vue.axios.get('/getChatUser')
    .then(({data})=>{
        commit(types.getChatlist,data)
    })
        }
    },
    getters:{
        getChatlist(state){
            return state.chat_data
        }
    }
}
export default chat