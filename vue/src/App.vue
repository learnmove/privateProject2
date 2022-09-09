<template>
  <div id="app">
    <div class="container">
    <!-- nav -->
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span> 
          </button>
          <a class="navbar-brand" ><router-link  to="/product"><a @click="a()" href="#"><span class="glyphicon glyphicon-user"></span> 校園拍賣</a></router-link></a>
          
        </div>
       
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li class="active"><router-link :to="{name:'product'}"><a href="#">商品</a></router-link></li>
            <li><router-link v-if="isAuth" :to="{name:'product_create'}"><a href="#">刊登商品</a></router-link></li>
            <li><router-link v-if="isAuth" :to="{name:'order'}"><a href="#">購買清單</a></router-link></li> 
            <li><router-link v-if="isAuth" :to="{name:'sellout'}"><a href="#">售出清單</a></router-link></li> 
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><router-link v-if="isAuth" :to="{name:'cart'}"><a href="#"><span class="badge">{{getTotalQty}} </span>購物車</a></router-link></li> 
            <li><router-link  v-if="isAuth" :to="{name:'mysell'}"><a href="#"><span class="glyphicon glyphicon-log-in"></span> 我的商店</a></router-link></li>
              <li><router-link v-if="isAuth" :to="{name:'change_school'}"><img style="width:35px; height:35px" v-bind:src="$auth.getUser().avatar" alt="" class="img-circle"><a href="#">{{$auth.getUser().account}}</a></router-link></li> 
            <li><a href="#" v-if="isAuth" @click.prevent="logout">登出</a> </li>
            <li><router-link v-if="!isAuth" :to="{name:'signup'}"><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></router-link> </li>
            <li><router-link  v-if="!isAuth" :to="{name:'login'}"><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></router-link></li>
            
            
          </ul>
        </div>
      </div>
    </nav>
    <!-- nav -->
    <router-view ></router-view>

    </div>
    <div>
      
  <router-link v-if="$auth.getUser()" @click.native="haveChat=''" :to="{name:'chat'}" tag="button" class="chat btn btn-chat"><i class="fa fa-comments-o" aria-hidden="true"></i>
聊聊<div class="badge" v-if="haveChat!=0">O</div></router-link>
    </div>
     <div class="dropup" v-if="$auth.getUser()">
  <button @click="MarkRead" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
    <span class="glyphicon glyphicon-globe">消息</span>
  <span class="badge " v-if="dispalyBadge">{{UnReadMessageCount}} </span>
</button>
  <ul class="dropdown-menu">
    <li  v-for="message in messages">
      <div class="purchase flex" >
        <img style="width:30px;height:30px;" class=" img-circle img-responsive" :src="message.data.avatar" alt="">
      <a href="#" >{{message.data.message}} </a>
      </div>
      
      </li>
  </ul>
</div>
  </div>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
  name: 'app',
  components:{
  },
  data(){
    return {
      messages:[],
      haveChat:0,
      refresh:0,
      UnReadMessageCount:0,
      dispalyBadge:false,
      isAuth: this.$auth.isAuthenticate()

    }
  },
  watch:{
      '$route':function(){
          this.isAuth=this.$auth.isAuthenticate()
      },
    
  },
  beforeMount(){
    if(this.$auth.getUser()){
      this.Getnotify()
      this.GetUnreadMessage()
    }
    let that=this
    // this.$echo.private('App.User.' + this.$auth.getUserId())
    // .listen('.event',function(data){
    //   console.log(data)
    //         that.haveChat++
    // })
    // .notification((message) => {
    //     this.messages.unshift(message)
    //     this.UnReadMessageCount++
    //     this.dispalyBadge=true
    // });
  },
  methods:{
    a(){
      this.refresh++;
    },
    Getnotify(){
      this.axios.get('/Getnotify')
      .then((res)=>{
        console.log(res.headers)
        this.messages=res.data 
        this.UnReadMessageCount=this.messages.filter(item=>{return item.read_at===null}).length

        if(this.UnReadMessageCount>0){
          this.dispalyBadge=true
        }
      })
    },
    MarkRead(){
      if(this.dispalyBadge==true){
        this.axios.get('/MarkRead')
       this.UnReadMessageCount=0
       this.dispalyBadge=false
       
      }
    
    },
    GetUnreadMessage(){
        this.axios.get('/getunread_message').then((res)=>{
          console.log(res.data)
          this.haveChat = res.data.have_message;
        })

    },
    logout(){
        this.$auth.destroyLogin()
        this.$swal('已登出')
         this.isAuth=false
       
    }
  },
        computed:{
        //    ...mapGetters('cart',['getTotalQty'])
//         getTotalQty () {
//             return this.$store.getters.cart.getTotalQty()
//   }
           ...mapGetters('cart',['getTotalQty'])

        }
}
</script>

<style scoped="true">
.chat{
  position: fixed;
  bottom:5px;
  right:0px;
}
.dropup{
   position: fixed;
  bottom:5px;
  left:0px;
}
.flex{
  display:flex;
}
.badge{
      color: #ffffff;
    background-color: #FA3E3E;
}
.btn-chat{
  background-color: #00BFA5;
  color:#fff;
}
</style>
