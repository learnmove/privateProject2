<template>
  <div class="container">
      <div class="row">
       <pagination :method_name="method_name" @fetchProducts="fetchProducts"  :last_page="products.last_page"></pagination>
      </div>
  <div class="col-sm-6 col-md-4" v-for="product in products.data">
    <div class="thumbnail">
      <div v-if="product.user_id==$auth.getUser().id" class="text-right text-danger">
          <button @click="deleteProduct(product)" class="btn btn-danger">x</button>
          <router-link tag="button" class="btn btn-primary" :to="{name:'product_edit',params:{pid:product.id}}">俢改</router-link>
          </div>
      <img :src="product.img" alt="">
     <div class="caption">
        <h3>{{product.name}}</h3>
        <p>{{product.description}}</p>
        <span class="text-waring">${{product.price}} </span>
        <div class="">數量{{product.qty}} </div>
        <div class="">賣家：<router-link :to="{name:'userstore',params:{'user_account':product.user.account}}">{{product.user.account}}</router-link> </div>


 <div v-if="product.user_id!=$auth.getUser().id" class="">
         選擇數量<select v-model.number="product.purchaseQty" value="1" >
                <option :value=n v-for="n in product.qty">{{n}}</option>
            </select>
   
            <div class="">
        <a href="#" @click.prevent="purchase(product)" class="btn btn-default" role="button">放進購物車</a></p>

            </div>
          </div>
            
      </div>
    </div>
  </div>
  
  <div class="row">
       <pagination :method_name="method_name" @fetchProducts="fetchProducts"  :last_page="products.last_page"></pagination>
      
  </div>
  
</div>
</template>
<script>
import {mapActions,mapGetters,mapState} from 'vuex'
import pagination from'@/components/pagination.vue'
    export default{
        beforeMount(){
            this.fetchProducts()
        },
        data(){
            return{
                method_name:'fetchProducts'
            }
        },
      
      methods:{
      
        //   ...mapActions('products',['fetchProducts'],this.page)
        fetchProducts(pagination={page:1}){
            console.log(pagination)
            return this.$store.dispatch('products/fetchProducts',pagination.page)},
        deleteProduct(product){
            const that=this
            this.$swal({
  title: "確定要刪除?",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "Yes,刪了它吧!",
  cancelButtonText: "No, 我按錯了!",

}).then(function(){
    that.$store.dispatch('products/deleteProduct',product)
    that.$swal('刪了')});
        },
        purchase(product){
            if(this.$auth.isAuthenticate()){
                if(product.purchaseQty){
                    this.$store.dispatch('cart/addItem',product)
                    this.$swal('放進去了')
                }else{
                    this.$swal('你沒選數量')
                }
            
            }else{
                this.$swal('請先登入')
            }
        
        }
      },
      computed:{
        //   ...mapGetters('products',['getProducts'])
        ...mapState('products',['products'])
      },
      components:{
          pagination
      }
    }
</script>
