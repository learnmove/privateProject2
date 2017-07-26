<template>
<div class="container">
<pagination :method_name="method_name" @fetchProducts="fetchProducts"  :last_page="order_info.last_page"></pagination>
     <ul class="nav nav-pills">
  <li role="presentation" class="active"><a href="#" @click.prevent="filter_buy('fetchAllOrders')">所有訂單</a></li>
  <li role="presentation"><a href="#" @click.prevent="filter_buy('buycomplete')">完成清單</a></li>
  <li role="presentation"><a href="#" @click.prevent="filter_buy('buyrefund')">退貨清單</a></li>
  <li role="presentation"><a href="#" @click.prevent="filter_buy('buycancell')">取消清單</a></li>
</ul>
    <div class="panel panel-default" v-for="order in orders ">
        <div class="panel-heading">
            <span class="text-center">購買清單</span>
        </div>
    <div class="pane-body"  v-for="item in order.items">
<table class="table table-striped " >

            <tr>
            <th>購買日期</th>
            <th>商品名稱</th>
           
            </tr>
            
            <tr>
                <td>{{item.created_at}} </td>
                <td>{{item.product.name}} </td>
               
            </tr>
            
            <!--<tr>
                <td colspan="">總價</td>
                <td colspan="">${{order.total_price}} </td>
                
            </tr>-->
  </table>
<table class="table table-striped " >

            <tr>
           
            <th>數量</th>
            <th>總共</th>
            <th>賣家</th>
            </tr>
            
            <tr>
              
                <td>
                    {{item.item_total_qty}} 
                    </td>
                <td>${{item.item_total_price}} </td>
                <td>
                    <router-link :to="{name:'userstore',params:{'user_account':item.product.user.account}}">{{item.product.user.account}} </router-link>
                    <button class="btn btn-danger" @click="chat_select(item.seller_id)">聊聊</button>

                 </td>
            </tr>
            
            <!--<tr>
                <td colspan="">總價</td>
                <td colspan="">${{order.total_price}} </td>
                
            </tr>-->
  </table>
    <table class="table table-striped " >
       <thead>
 <tr>
            <th>訂單管理</th>
            <th>訂單狀態</th>
            <th>訂單取消</th>
            </tr>
       </thead>
           <tr>
                <td v-if="item.item_status[0].id==1"><button class="btn btn-primary btn-xs" @click="statusConfirm(item,2)">付款確認</button> </td>
                <td v-if="item.item_status[0].id==7"><button class="btn btn-primary btn-xs" @click="statusConfirm(item,15)">收貨確認</button> </td>
                <td v-if="item.item_status[0].id==8&&item.item_status[0].pivot.requester_id!==$auth.getUserId()"><button class="btn btn-primary btn-xs" @click="statusConfirm(item,9)">同意取消交易</button> </td>
                <td>{{item.item_status[0].content}} </td>
                <td v-if="item.item_status[0].id==12" ><button class="btn btn-primary btn-xs"  @click="statusConfirm(item,10)">要求退貨</button> </td>
                <td v-if="item.item_status[0].id==1||item.item_status[0].id==2||item.item_status[0].id==2"><button class="btn btn-primary btn-xs"  @click="statusConfirm(item,8)">要求取消交易</button> </td>

              
            </tr>
                
  </table>
  <table v-if="!item.rating">
             <tr>
                 <td>
                       <Rate  v-if="item.item_status[0].id==9||item.item_status[0].id==12||item.item_status[0].id==11"  :value="item.rating?item.rating.level:1"   @afterRate="onAftereRate" :item="item"  :length="5"></Rate>
                 </td>
             </tr>
  </table>
  <table v-if="!item.rating_comment">
          <input  v-if="item.item_status[0].id==9||item.item_status[0].id==12||item.item_status[0].id==11" class="form-control" type="text" v-model="item.feedback">
    <td v-if="item.item_status[0].id==9||item.item_status[0].id==12||item.item_status[0].id==11"><button class="btn btn-primary btn-xs" @click="itemfeedback(item)">評價</button> </td>
                 </td>
  </table>

    </div>
 <tr>
      <td colspan="">訂單總價</td>
                <td colspan="">${{order.total_price}} </td>

</tr>
    </div>

  </div>
</template>
<script>
import pagination from '@/components/pagination.vue'
import Rate from '@/components/plugin/Rate.vue'
   export default{
       components:{
       },
       data(){
           return{
            
            orders:[],
            order_info:{},
            method_name:'fetchAllOrders',
            page:1
           }
       },
       components:{
           Rate,
           pagination
       }
       ,
        beforeMount(){
       this.fetchData()
        
    },
    methods:{
          chat_select(seller_id){
              this.axios.post('/addChatUser',{chat_id:seller_id})
              .then(({data})=>{
                this.$router.push({name:'chat'})
            })
          },
        filter_buy(method_name){
            this.method_name=method_name;
        },
        fetchProducts({page}){
            this.page=page
            this.fetchData()
        },
      itemfeedback(item){
        this.axios.post('/itemfeedback',{item:item})
        .then(({data})=>{
            this.$swal('評價成功')
            this.fetchData()
    })
      },
        onAftereRate(rate,item) {
            this.axios.post(`/rating`,{item:item,level:rate})
            .then(({data})=>{this.$swal('評分成功')
            this.fetchData()
        })
        },
        statusConfirm(item,status){

            this.axios.put(`/items/${item.id}`,{status:status})
            .then(({data})=>{
       this.fetchData()
                this.$router.push({redirect:{name:'sellout'}})
                })
            .catch((error)=>console.log(error.response))
        },
        fetchData(){
             this.axios.get(`invoice?page=${this.page}&method_name=${this.method_name}`)
        .then(({data})=>{
            this.orders=data.data;
            delete data.data
            this.order_info=data
        })
        }
    }
   }

</script>
<style>
.pane-body{
  border-bottom:solid silver 5px;
}
</style>
