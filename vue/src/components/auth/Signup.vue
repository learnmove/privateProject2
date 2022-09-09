<template>
  <div class="signup col-md-6 col-md-offset-3">
      <div class="panel panel-default">
          <div class="panel-body">
 <form @submit.prevent="signup" class="form-horizontal">
          <div class="form-group">
              <label for="" class="control-label col-sm-2">帳號</label>
              <div class="col-sm-10">
              <input v-model="form.account" class=" form-control" type="text" placeholder="y5824u" >

              </div>
              </div>
                <div class="form-group">
              <label for="" class="control-label col-sm-2">信箱</label>
              <div class="col-sm-10">
              <input v-model="form.email" class=" form-control" type="text" placeholder="*@gmail.com" >

              </div>
              </div>
              <div class="form-group">
    <label class="control-label col-sm-2" for="email">密碼:</label>
    <div class="col-sm-10">
      <input type="password" v-model="form.password" class="form-control" id="email" placeholder="Enter password">
    </div>
  </div>
     <div class="form-group">
    <label class="control-label col-sm-2" for="email">確認:</label>
    <div class="col-sm-10">
      <input type="password" v-model="form.password_confirmation" class="form-control" id="email" placeholder="Enter password">
    </div>
  </div>
  <div class="form-group">
      <label for="" class="col-sm-2 control-label">姓名</label>
      <div class="col-sm-10">
          <input v-model="form.name" type="text" name="" id="" class="form-control">
      </div>
  </div>
  <div class="form-group">

         <label for="" class="col-sm-2 control-label">學校</label>
      <div class="col-sm-10">
      </div>
      
  </div>
  <button type="submit" class="btn btn-primary pull-right">註冊</button>
      </form>
         <select data-live-search="true"  class="selectpicker" v-model="form.school_id" >
      <option v-for="school in schools" :value="school.id">{{school.name}} </option>
  </select> 
          </div>
      </div>
     
  </div>
</template>
<script>
    export default{
        data(){
            return{
                schools:[],
                form:{
                    email:'',
                    password:'',
                    password_confirmation:'',
                    name:'',
                    school_id:'',
                    account:''
                },
                source:'/register'

            }
        },
        beforeMount(){

            this.fetchSchoolList()
        }
        ,
        methods:{
             fetchSchoolList(){
              this.axios.get('/schoolist')
              .then(({data})=>{
                this.schools=data;
                setTimeout(function(){
                  $(".selectpicker").selectpicker("refresh");
                }, 0)


              })
          },
            signup(){
                this.axios.post(this.source,this.form)
                .then(({data})=>{
                    console.log(data)
                    this.$swal("註冊成功")
                })
                .then(()=>{
                    this.$router.push('login')
                    
                })
                .catch((error)=>{console.log(error)})
            }
        }
    }
</script>