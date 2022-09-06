<template>
  <div class="container checkout">
      <table class="table table-striped checkout">
        <thead>

            <tr>
            <th>商品名稱</th>
            <th>價格</th>
            <th>數量</th>
            <th>總共</th>
            <th>操作</th>
            </tr>
            
        </thead>
        <tbody>
            <tr v-for="item in items">
                <td>{{item.name}} </td>
                <td>${{item.price}} </td>
                <td>
                    <button class="btn btn-waring" @click="inc(item)">+</button>
                    {{item.quantity}} 
                    <button class="btn btn-danger" @click="dec(item)">-</button>
                    </td>
                <td>${{item.itemTotal}} </td>
                <td><button class="btn btn-danger" @click="removeItem(item)">刪除</button> </td>
            </tr>
            <tr>
                <td colspan="">總價</td>
                <td colspan="">${{getTotalPrice}} </td>
                <td colspan="">總數量 </td>
                <td colspan="">{{getTotalQty}} </td>
                <td colspan=""><button class="btn btn-primary pull-right" @click.prevent="checkout">結帳</button> </td>

            </tr>
        </tbody>
  </table>
        
  
  </div>
</template>
<script>
import {mapState,mapGetters} from 'vuex'
    export default{
        data(){
            return {
                source:`/invoice`
            }
        }
        ,
        methods:{
            checkout(){
                this.axios.post(this.source,this.form)
                .then(({data})=>{
                    this.$swal(data)
                    this.$store.dispatch('cart/clearnItems')
                })
                .catch((error)=>console.log(error.response))
            },
            removeItem(item){
                this.$store.dispatch('cart/removeItem',item)
            },
            inc(item){
                this.$store.dispatch('cart/incrementQty',item)
            },
            dec(item){
                this.$store.dispatch('cart/decrementQty',item)
            }
        },
        computed:{
            // ...mapState({
            //     items:state=>state.cart.items
            // })
             ...mapState('cart',['items']),
             ...mapGetters('cart',['getTotalPrice','getTotalQty'])
        //     items(){
        //         return this.$store.state.cart.items
                
        // }
            ,
            form(){
                return {
                    total_price:this.getTotalPrice,
                    total_qty:this.getTotalQty,
                    items:this.items
                
                     }
            }
          
        }
    }
</script>
<style>
    .checkout{
        margin-bottom: 50px;
    }

</style>