<template>
  <div class="container">
      <table class="table table-striped">
        <thead>

            <tr>
            <th>商品名稱</th>
            <th>價格</th>
            <th>數量</th>
            <th>總共</th>
            </tr>
            
        </thead>
        <tbody>
            <tr v-for="item in items">
                <td>{{item.name}} </td>
                <td>${{item.price}} </td>
                <td>{{item.qty}} </td>
                <td>${{item.itemTotal}} </td>
            </tr>
            <tr>
                <td colspan="">總價</td>
                <td colspan="">${{getTotalPrice}} </td>
                <td colspan="">總數量 </td>
                <td colspan="">{{getTotalQty}} </td>
                
            </tr>
        </tbody>
  </table>
        <button class="btn btn-primary pull-right" @click.prevent="checkout">結帳</button>
  
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
                .then(({data})=>console.log(data))
                .then((error)=>console.log(error.response.data))
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
