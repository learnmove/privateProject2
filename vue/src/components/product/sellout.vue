<template>
<div>
 <div class="panel panel-default" v-for="item in items">
        <div class="panel-heading">
            <span class="text-center">售出清單</span>
        </div>
<div class="" >
        
 <table class="table table-striped " >
     <thead>
 <tr>
            <th>售出日期</th>
            <th>商品名稱</th>
            </tr>
     </thead>
            <tr >
                <td>{{item.created_at}} </td>
                <td>{{item.product.name}} </td>
            </tr>
  </table>
  <table class="table table-striped " >
      <thead>
 <tr>
            <th>數量</th>
            <th>總共</th>
            <th>買家</th>
            </tr>
      </thead>
            <tr >
                <td>
                    {{item.item_total_qty}} 
                    </td>
                <td>${{item.item_total_price}} </td>
                <td>{{item.invoice.user.account}} </td>
              
            </tr>
            
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
                <td v-if="item.item_status[0].id==2 "><button class="btn btn-primary btn-xs" @click="statusConfirm(item,3)">收款確認</button> </td>
                <td v-if="item.item_status[0].id==3 "><button class="btn btn-primary btn-xs" @click="statusConfirm(item,4)">出貨確認</button> </td>
                <td v-if="item.item_status[0].id==9||item.item_status[0].id==12||item.item_status[0].id==11 "><button class="btn btn-primary btn-xs" >評價</button> </td>
                <td v-if="item.item_status[0].id==8&&item.item_status[0].pivot.requester_id!==$auth.getUserId()"><button class="btn btn-primary btn-xs" @click="statusConfirm(item,9)">同意取消交易</button> </td>
                <td>{{item.item_status[0].content}} </td>
                <td ><button class="btn btn-primary btn-xs" v-if="item.item_status[0].id==10" @click="statusConfirm(item,14)">同意退貨</button> </td>
                <td ><button class="btn btn-primary btn-xs" v-if="item.item_status[0].id==1||item.item_status[0].id==2||item.item_status[0].id==3" @click="statusConfirm(item,8)">要求取消交易</button> </td>
                
              
            </tr>
  </table>
               </div> 

     
  
  </div>
</div>
   
</template>
<script>
   export default{
       data(){
           return{
            items:[]
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
              this.axios.get(`/items`)
        .then(({data})=>{this.items=data;})
        }
    }
   }

</script>
