<template>
      <div class="col-sm-10">
	<h5>改變學校</h5>

         <select data-live-search="true" data-live-search-style="startsWith" class="selectpicker"  id="" v-model="school_id">
      <option v-for="school in schools" :value="school.id"  >{{school.name}} </option>
  </select> 
 <button class="btn btn-primary" @click="change_school">確認</button>
      </div>
</template>
<script>
import {mapActions,mapState,mapGetters} from 'vuex'
import store from '@/store/index'
export default{
    data(){
        return{
        	schools:[],
        	school_id:''
        }
    },
    beforeMount(){
    	this.fetchSchoolList()
    // this.axios.get(`/chatcontent?chat_id=${}`)
    },
    computed:{
       
    },
    // watch:{
    //     chat_data:function(){
    //     this.getChannel()
    //     }
    // },
  
    methods:{
          fetchSchoolList(){
              this.axios.get('/schoolist')
              .then(({data})=>{
              	this.schools=data
              	this.schools.forEach((i)=>{
              		if(i.id== this.$auth.getUser().school_id)this.school_id=i.id
              	})
                setTimeout(function(){
                  $(".selectpicker").selectpicker("refresh");


                }, 0)
              })
          },
          change_school(){
          	this.axios.post('/changeSchool',{school_id:this.school_id}).then(()=>{
              this.$swal('改變成功')
              this.$auth.setSchoolId(this.school_id);
          	})
          }
    }
}
</script>