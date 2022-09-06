import Vue from 'vue'
const types={
    getChatlist:'get_chat_list',
    setUnread:'setUnread',
    setUser: 'set_user'
}
const chat={
    namespaced: true,
    state:{
        chat_data:{
            chat_user:[]
        },
        chat_message:[],
        target_user_id:''
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
        },
        [types.setUser](state,user_id){
                state.target_user_id=user_id
        }
    },
    actions:{
        getChatlist({commit}){
        Vue.axios.get('/getChatUser')
    .then(({data})=>{
        commit(types.getChatlist,data)
    })
        },
        setUser({commit},user_id){
            commit(types.setUser,user_id)
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