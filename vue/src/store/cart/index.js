const types={
    addItem:'addItem',
    RemoveItem:'RemoveItem',

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
                    price:item.price,
                    itemTotal:item.purchaseQty*item.price
                }
                )
            }
            
        }
    },
    actions:{
        addItem({commit},item){
            commit(types.addItem,item)
        }
    },
    getters:{
        getTotalQty(state,getters){

               
                
     let Qty=state.items.reduce((total,item)=>{
              return  total+item.qty
                
            },0)
           return Qty
        },
        getTotalPrice(state,getters){
         let totalPrice=state.items.reduce((total,item)=>{
              return  total+item.itemTotal
                
            },0)
           return totalPrice
    }

    }
}
export default cart