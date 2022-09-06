<template>
  <div id="app">
    <div class="container">
    <nav-bar></nav-bar>
    <router-view></router-view>

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
import Navbar from'@/components/Navbar'
export default {
  name: 'app',
  components:{
    'nav-bar':Navbar
  },
  data(){
    return {
      messages:[],
      haveChat:0,

      UnReadMessageCount:0,
      dispalyBadge:false
    }
  },
  beforeMount(){
    if(this.$auth.getUser()){
      this.Getnotify()
      this.GetUnreadMessage()
    }
    let that=this
    this.$echo.private('App.User.' + this.$auth.getUserId())
    .listen('.event',function(data){
      console.log(data)
            that.haveChat++
    })
    .notification((message) => {
        this.messages.unshift(message)
        this.UnReadMessageCount++
        this.dispalyBadge=true
    });
  },
  methods:{
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

    }
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
