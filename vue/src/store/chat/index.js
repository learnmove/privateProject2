import Vue from 'vue'
const types={
    getChatlist:'get_chat_list',
    setUnread:'setUnread'
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
                 
            
        },
        [types.setUnread](state,user){
            let index=state.chat_data.indexOf(user)
            //  state.chat_data[index].unread_id=0
                Object.defineProperty(
         state.chat_data[index].pivot,
        'unread_id',
        {value:0})
        }
    },
    actions:{
        getChatlist({commit}){
        Vue.axios.get('/getChatUser')
    .then(({data})=>{
        commit(types.getChatlist,data)
    })
        },
        setUnread({commit},user){
            commit(types.setUnread,user)
        }
    },
    getters:{
        getChatlist(state){
            return state.chat_data
        }
    }
}
export default chat