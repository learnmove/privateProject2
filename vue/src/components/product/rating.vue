<template>
  <div class="container">
      <div class="jumbotron">
  	<svg class="progress-circle-svg" viewBox="0 0 200 200" version="1.1" preserveAspectRatio="xMidYMid meet"
                xmlns="http://www.w3.org/2000/svg">
            <circle class="progress-circle-background" r="90" cx="50%" cy="50%" fill="#FFFFFF"
                    stroke-dasharray="565.48"
                    stroke-dashoffset="0"></circle>
            <circle class="progress-circle-bar" r="90" cx="50%" cy="50%" fill="transparent"
                    stroke-dasharray="565.48"
                    stroke-dashoffset="0"></circle>
            <circle class="progress-circle-inner" r="80" cx="50%" cy="50%" fill="#42D0BC"
                    stroke-dasharray="565.48"
                    stroke-dashoffset="0"></circle>
                        <text x="50%" y="50%" text-anchor="middle" stroke="#fff" stroke-width="0px" dy=".1em">4.5</text>

        </svg>
        <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>

      </div>
      <div class="row">
     <div class="panel panel-default">
         <div class="panel-heading">
             <h4 class="text-center">賣場評價</h4>
         </div>
         <div class="panel-body">
             <ul class="" style="list-item:none; display:flex;">
  <li class="active"><a href="#" @click.prevent="filterStar('fetchData')">全部</a></li>
  <li><a href="#" @click.prevent="filterStar('StarOne')">1顆星</a></li>
  <li><a href="#" @click.prevent="filterStar('StarTwo')">2顆星 </a></li>
    <li><a href="#" @click.prevent="filterStar('StarThree')">3顆星 </a></li>
      <li><a href="#" @click.prevent="filterStar('StarFour')">4顆星 </a></li>
        <li><a href="#" @click.prevent="filterStar('StarFive')">5顆星 </a></li>
</ul>
<Page @fetchProducts="fetchProducts" :last_page="pages.last_page" :method_name="method_name"></Page>
                <ul>
            <li v-for="item in items">
                <div class="user">買家：{{item.rating.user.account}} </div>
      <Rate :value="parseInt(item.rating.level)"  :length="5"></Rate>
      <div class="comment">
          {{item.rating_comment?item.rating_comment.feedback:''}}
      </div>
      <div class="product">
          <div class="product-img">
              <img class=" img-responsive" :src="item.product.img" alt="">
          </div>
              <div class="product-name">{{item.product.name}} </div>
      </div>
      <div class="date">
                 {{item.rating.created_at}}
             </div>
            </li>
             
        </ul>
         </div>
     </div>
      </div>
  </div>
</template>
<script>
import {mapState,mapGetters} from 'vuex'
import Rate from '@/components/plugin/Rate.vue'
import Page from '@/components/pagination.vue'
    export default{
        components:{Rate,Page},
        data(){
            return{
               method_name:'fetchData',
                page:1
            }
        },
        beforeMount(){
            this.fetchData();
        },
        methods:{
            fetchProducts(n){
               
                this.page=n.page
                // this[method_name]
                // 動態執行方法，傳入名字
                this.fetchData()
            },

            fetchData(){
                console.log('ii')
               this.$store.dispatch('ratings/get_item_rating',
               {user_account:this.$route.params.user_account,
                   page:this.page,
                   method_name:this.method_name

                })
            },
            filterStar(method_name){
                this.method_name=method_name
                this.fetchData()
            }
        }
        ,
        computed:{
            ...mapState('ratings',['items','pages']),
            
        }
    }
</script>
<style scoped>
.container{
    max-width: 600px;
    background-color: #FFFFFF;
}
.jumbotron{
    background-color: #00BFA5;
}
i{
    color:#FFFFFF;
    font-size: 50px;
}
text{
    color:#fff;
}
ul{
    list-style: none;
    padding:0px 5px;
}
li{
    background-color: #F5F5F5;
    margin-top: 10px;
    padding: 10px;
}
.product-img{
    width:48px;
    height:48px;
    margin-right: 5px;
    
}
img{
    width:100%;
    height:100%;
}
.product{
    display: flex;
    background-color: rgb(222, 245, 245);
}
.panel-body{
    padding:1px;
}
.date{
    margin:20px 0 0 0;
}
</style>
