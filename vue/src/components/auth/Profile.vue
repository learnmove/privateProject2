<template>
  <div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="text-center">我的檔案
</h4>
      </div>
      <div class="panel-body">
        <form @submit.prevent="" class="form-horizontal">
          <div class="form-group">
            <div class="col-sm-2">
              <label for="">使用者名稱</label>
            </div>
            <div class="col-sm-10">
              <span>{{form.account}} </span>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-2">
              <label for="">改變學校</label>
            </div>
            <div class="col-sm-10">
              <select data-live-search="true" data-live-search-style="startsWith" class="selectpicker" id="" v-model="school_id">
                <option v-for="school in schools" :value="school.id">{{school.name}} </option>
              </select>
              <span> </span>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-2">
              <label for="">圖片</label>
            </div>
            <div class="col-sm-10">
              <input type="file" @change="imgChg" name="" id="" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-2">
              <label for="">電話</label>
            </div>
            <div class="col-sm-10">
              <span>{{form.phone}} </span>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-2">
              <label for="">Email</label>
            </div>
            <div class="col-sm-10">
              <span>{{form.email}} </span>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-2">
              <label for="">商店名稱</label>
            </div>
            <div class="col-sm-10">
              <input v-model="form.shop_name" type="text" name="" id="" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-2">
              <label for="">商店介紹</label>
            </div>
            <div class="col-sm-10">
              <textarea v-model="form.shop_description" name="" id="" cols="30" rows="10" class="form-control"></textarea>
            </div>
          </div>
          <button class="btn btn-primary">送出</button>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapState, mapGetters } from 'vuex'
import store from '@/store/index'
export default {
  data() {
    return {
      schools: [],
      school_id: '',
      form: { shop_description: '' }
    }
  },
  beforeMount() {
    this.fetchSchoolList();
    this.fetchProfile();
    // this.axios.get(`/chatcontent?chat_id=${}`)
  },
  computed: {

  },
  // watch:{
  //     chat_data:function(){
  //     this.getChannel()
  //     }
  // },

  methods: {
    fetchProfile() {
      this.axios.get('/getProfile')
        .then(({ data }) => {
          this.form = data

        }).then(() => {
          $(".selectpicker").selectpicker("refresh");

        })
    },
    fetchSchoolList() {
      this.axios.get('/schoolist')
        .then(({ data }) => {
          this.schools = data
          this.schools.forEach((i) => {
            if (i.id == this.$auth.getUser().school_id) this.school_id = i.id
          })
        }).then(() => {
          $(".selectpicker").selectpicker("refresh");

        })
    },
    change_school() {
      this.axios.post('/changeProfile', { school_id: this.school_id }).then(() => {
        this.$swal('改變成功')
        this.$auth.setSchoolId(this.school_id);
      })
    }
  }
}

</script>
