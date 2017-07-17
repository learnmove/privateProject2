<template>
<div class="container">
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
                <td>{{item.product.user.account}} </td>
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
                <td v-if="item.item_status[0].id==9||item.item_status[0].id==12||item.item_status[0].id==11 "><button class="btn btn-primary btn-xs" >評價</button> </td>
                <td v-if="item.item_status[0].id==1"><button class="btn btn-primary btn-xs" @click="statusConfirm(item,2)">付款確認</button> </td>
                <td v-if="item.item_status[0].id==7"><button class="btn btn-primary btn-xs" @click="statusConfirm(item,15)">收貨確認</button> </td>
                <td v-if="item.item_status[0].id==8&&item.item_status[0].pivot.requester_id!==$auth.getUserId()"><button class="btn btn-primary btn-xs" @click="statusConfirm(item,9)">同意取消交易</button> </td>
                <td>{{item.item_status[0].content}} </td>
                <td ><button class="btn btn-primary btn-xs" v-if="item.item_status[0].id==12" @click="statusConfirm(item,10)">要求退貨</button> </td>
                <td ><button class="btn btn-primary btn-xs" v-if="item.item_status[0].id==1||item.item_status[0].id==2||item.item_status[0].id==2" @click="statusConfirm(item,8)">要求取消交易</button> </td>

              
            </tr>
  </table>
  <table>

  </table>

  <hr>
    </div>
 <tr>
      <td colspan="">訂單總價</td>
                <td colspan="">${{order.total_price}} </td>

</tr>
    </div>
     
  
  </div>
</template>
<script>
   export default{
       data(){
           return{
            orders:[]
           }
       },
        beforeMount(){
       this.fetchData()
        
    },
    methods:{
        statusConfirm(item,status){

            this.axios.put(`/items/${item.id}`,{status:status})
            .then(({data})=>{
                console.log(data);
       this.fetchData()
                this.$router.push({redirect:{name:'sellout'}})
                })
            .catch((error)=>console.log(error.response))
        },
        fetchData(){
             this.axios.get(`invoice`)
        .then(({data})=>{this.orders=data;console.log(data);})
        }
    }
   }

</script>
