<template>
  <div class="container">

  <div class="row">
      <div class="panel panel-panel-info">
          <div class="panel-heading">
            <tbody>
              <tr>
                <td><i class="fa fa-shopping-bag" aria-hidden="true"></i>商品：<span>{{store_info.countProduct}}</span></td>
                <td><i class="fa fa-user-circle" aria-hidden="true"></i>加入時間：<span>{{store_info.user?store_info.user.created_at:''}}</span> </td>
                <td><i class="fa fa-star-o" aria-hidden="true">評價</i> <router-link :to="{name:'user_ratting',params:{user_account:this.$route.params.user_account}}"><span>{{store_info.countRateOfUser}}個評價</span></router-link></td>
              </tr>
            </tbody>
                
               
               
            <div>
            </br>
              如果是買全新商品，通常就是看看商品價格、賣場評價就好。但如果是買二手商品，要注意的 ... 也是在網頁版賣家中心，我才發現原來可以填寫賣場介紹。如果是買全新商品，通常就是看看商品價格、賣場評價就好。但如果是買二手商品，要注意的 ... 也是在網頁版賣家中心，我才發現原來可以填寫賣場介紹。
                           如果是買全新商品，通常就是看看商品價格、賣場評價就好。但如果是買二手商品，要注意的 ... 也是在網頁版賣家中心，我才發現原來可以填寫賣場介紹。如果是買全新商品，通常就是看看商品價格、賣場評價就好。但如果是買二手商品，要注意的 ... 也是在網頁版賣家中心，我才發現原來可以填寫賣場介紹。
            </div>
          </div>
      </div>
  </div>

      <div class="row">
       <pagination @fetchProducts="fetchProducts"  :last_page="products.last_page"></pagination>
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
        <div class="">賣家：{{product.user.account}} </div>


 <div v-if="product.user_id!=$auth.getUser().id" class="">
         選擇數量<select v-model.number="product.purchaseQty" value="1" >
                <option :value=n v-for="n in product.qty">{{n}}</option>
            </select>
   
            <div class="">
        <a href="#" @click.prevent="purchase(product)" class="btn btn-default" role="button">放進購物車</a></p>

            </div>

          </div>
   <button class="btn btn-primary" @click="showinput(product)">詢問/商品留言</button>
            
      </div>
    </div>
  </div>
  <div class="row">
            <modal title="Modal Title" :show="OpenModal" @cancel="cancel">
          <div class="form-group"><input type="text" v-model="question_content" name="" id="" class="form-control"></div>
          <button class="btn btn-primary" @click="sendQuestion">送出訊息</button>

 <div class="media" v-for="question in questions">
  <a class="media-left media-middle" href="#">
  </a>
  <div class="media-body">
    <h4 class="media-heading">{{question.account}}</h4>
    <div class="ask">
        <div>
         {{question.content}}
        </div>
    </div>
    <div class="date">
        {{question.created_at}}
    </div>
  </div>
</div>

<pagination @fetchProducts="questionPage" :passpage="question_page" :last_page="question_info.last_page"></pagination>


</modal>
  </div>
</div>
</template>
<script>
import {mapActions,mapGetters,mapState} from 'vuex'
import pagination from '../pagination'
import modal from'@/components/plugin/Modal.vue'

    export default{
        beforeMount(){
            this.fetchProducts()
        },
        data(){
            return{
                  OpenModal:false,
                questions:[{}],
                question_info:{},
                question_content:'',
                question_page:'',
                selectProduct:{}
                
            }
        },
      
      methods:{
               sendQuestion(){
                   if(this.$auth.getUser()){
  this.axios.post(`/question`,{product_id:this.selectProduct.id,account:this.$auth.getUser().account,content:this.question_content,seller_id:this.selectProduct.user_id})
            .then(({data})=>{
                this.$swal(data) 
                this.question_content=''
            this.fetchQuestion(this.selectProduct)
        })
                   }
          else{
              this.$swal('請先登錄')
          }
          },
      
        //   ...mapActions('products',['fetchProducts'],this.page)
         questionPage(pagination){
            this.question_page=pagination.page
            
            this.fetchQuestion(this.selectProduct)
            
          },
          cancel(){
                this.OpenModal=false
            
          },
          showinput(product){
             this.question_page=1
              
            this.OpenModal=!this.OpenModal
            if(this.OpenModal==true){
            this.fetchQuestion(product)
            }
          },
          fetchQuestion(product){
              this.selectProduct=product
            this.axios.get(`/question/${product.id}?page=${this.question_page}`)
            .then(({data})=>{
                this.questions=data.data
                delete data.data
                this.question_info=data
            })
          },
        fetchProducts(pagination={page:1}){
            return this.$store.dispatch('products/fetchUserProducts',
            {user_account:this.$route.params.user_account,
                pagination:pagination}
                )},
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
        ...mapState('products',['products','store_info']),
      },
      components:{
          pagination,
          modal
      }
    }
</script>
<style scoped  >

td {
 padding: 10px;
 
}
td span{
     color:#FF5722;

 }
 i{
     color:#000000;
     margin-right: 5px;
 }
 .panel{
 }
</style>
