<template>
  <div class="signup col-md-6 col-md-offset-3">
      <div class="panel panel-default">
          <div class="panel-body">
 <form @submit.prevent="login" class="form-horizontal">
          <div class="form-group">
              <label for="" class="control-label col-sm-2">帳號</label>
              <div class="col-sm-10">
              <input v-model="form.account" class=" form-control" type="text"  >

              </div>
              </div>
              <div class="form-group">
    <label class="control-label col-sm-2" for="email">密碼:</label>
    <div class="col-sm-10">
      <input v-model="form.password" type="password" class="form-control" id="email" placeholder="Enter password">
    </div>
  </div>
   <button type="submit" class="btn btn-primary pull-right">登錄</button>

      </form>
          </div>
      </div>
     
  </div>
</template>
<script>
import Vue from 'vue'
    export default{
        data(){
            return {
                source:'/login',
                form:{
                    account:'',
                    password:''
                },
                user:{}
            }
        },
        beforeMount(){
           this.user= this.$auth.getUser();
        },
    
        methods:{
            login(){
                this.axios.post(this.source,this.form)
                .then(({data})=>{
                    this.$auth.setAuth(data.token,data.user)
                    this.$router.push({name:'hello'})
                   location.reload();
                    
            })
            
            .catch((error)=>{this.$swal('帳號密碼錯誤')})
           
            }
        }
    }
</script>