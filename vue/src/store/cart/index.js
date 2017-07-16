const types={
    addItem:'addItem',
    RemoveItem:'RemoveItem',
    incrementQty:'incrementQty',
    decrementQty:'decrementQty',
    clearnItems:'clearnItems'
}
const cart={
    namespaced:true,
    state:{
        items:[],
        
    },
    mutations:{
        [types.addItem](state,item){
        
            // state.items.push(item)
        let found=state.items.find(function(i){
            return i.id==item.id
        })
            if(found){
                let index=state.items.indexOf(found)
                state.items[index].qty=item.purchaseQty
                
            }else{
                state.items.push(
                    {
                    id:item.id,
                    name:item.name,
                    qty:item.purchaseQty,
                    restQty:item.qty,
                    price:item.price,
                    itemTotal:item.purchaseQty*item.price
                }
                )
            }
            
        },
        [types.RemoveItem](state,item){
           state.items= state.items.filter((product)=>{
                return product!==item
            })
        },
        [types.incrementQty](state,item){
            let index=state.items.indexOf(item)

            if(state.items[index].qty+1<=state.items[index].restQty){
               state.items[index].qty++ 
               state.items[index].itemTotal= state.items[index].qty*state.items[index].price
            }
        },
        [types.decrementQty](state,item){
            let index=state.items.indexOf(item)
            
            if(state.items[index].qty-1>=0){
               state.items[index].qty--
               state.items[index].itemTotal= state.items[index].qty*state.items[index].price
            }
        },
        [types.clearnItems](state){
            state.items=[]
        }
    },
    actions:{
        addItem({commit},item){
            commit(types.addItem,item)
        },
        removeItem({commit},item){
            commit(types.RemoveItem,item)
        },
        incrementQty({commit,rootState},item){
            console.log(rootState.products.products.data)
            commit(types.incrementQty,item)
        },
        decrementQty({commit},item){
            commit(types.decrementQty,item)
        },
        clearnItems({commit}){
            commit(types.clearnItems)
        }
    },
    getters:{
        getTotalQty(state,getters){

               if(state.items.length>0){
                   let Qty=state.items.reduce((total,item)=>{
              return  total+item.qty
                
            },0)
           return Qty
               }else{
                   return 0
               }
                
  
        },
        getTotalPrice(state,getters){
            if(state.items.length>0){
                  let totalPrice=state.items.reduce((total,item)=>{
              return  total+item.itemTotal
                
            },0)
           return totalPrice
            }else{
                return 0
            }
       
    }

    }
}
export default cart