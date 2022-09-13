<template>
  <div class="container">
      <div class="col-md-6 col-md-offset-3">
          <div class="panel panel-default">
              <div class="panel-heading">
                 <h4 class="text-center">上傳產品</h4>
              </div>
              <div class="panel-body">
                 <form @submit.prevent="upload" class="form-horizontal">
                        <div class="form-group" :class="{'has-error':errors.name}">
                        <div class="col-sm-2">
                            <label for="">名稱</label>
                            
                        </div>
                        <div class="col-sm-10">
                            <input v-model="form.name" type="text" name="" id="" class="form-control ">
                        <span :class="{'text-danger':errors.name}">{{errors.name}} </span>
                            
                        </div>
                    </div>
                       <div class="form-group" :class="{'has-error':errors.description}">
                        <div class="col-sm-2">
                            <label for="">敘述</label>
                            
                        </div>
                        <div class="col-sm-10">
                            <textarea v-model="form.description" name="" id="" cols="30" rows="10" class="form-control"></textarea>
                        <span :class="{'text-danger':errors.description}">{{errors.description}} </span>
                            
                        </div>
                    </div>
                    <div class="form-group" :class="{'has-error':errors.price}">
                        <div class="col-sm-2">
                            <label for="">價格</label>
                            
                        </div>
                        <div class="col-sm-10">
                            <input v-model="form.price" type="text" name="" id="" class="form-control">
                        <span :class="{'text-danger':errors.price}">{{errors.price}} </span>
                            
                        </div>
                    </div>
                       <div class="form-group" :class="{'has-error':errors.price}">
                        <div class="col-sm-2">
                            <label for="">數量</label>
                            
                        </div>
                        <div class="col-sm-10">
                            <input v-model="form.quantity" type="text" name="" id="" class="form-control">
                        <span :class="{'text-danger':errors.quantity}">{{errors.quantity}} </span>
                            
                        </div>
                    </div>
                        <div class="form-group" >
                        <div class="col-sm-2">
                            <label for="">圖片</label>
                            
                        </div>
                        <div class="col-sm-10">
                            <input type="file" @change="imgChg" name="" id="" class="form-control">
                        </div>
                        <div class="col-sm-12">
                          <img id="avatar" v-if="this.form.img!=''" :src="this.form.img" class="img-responsive" style="
                          width:150px;
                          display: block;
                          margin-left: auto;
                          margin-right: auto;
                          " alt="">
                        </div>
                    </div>
                      <div class="form-group" >
                        <div class="col-sm-2">
                            <label for="">分類</label>
                            
                        </div>
                        <div class="col-sm-10">
                        <select class="selectpicker" @change="selectCategory()" v-model="category_id">
                            <option v-for="category in categories" :value="category.id" >{{category.name}}</option>
                        
                            </select>

                        </div>
                    </div>
                      <div class="form-group" >
                        <div class="col-sm-2">
                            <label for="">子分類</label>
                            
                        </div>
                        <div class="col-sm-10">
                        <select class="selectpicker" @change="selectSubCategory()" v-model="sub_category_id" >
                            <option v-for="sub_category in sub_categories" :value="sub_category.id" >{{sub_category.name}}</option>
                        
                            </select>

                        </div>
                    </div>
                    <button class="btn btn-primary">送出</button>
                 </form>
                    
              </div>
          </div>
      </div>
  </div>
</template>
<script>
   export default{
        data(){
        return{
            method:'post',
            form:{
                name:'',
                description:'',
                price:'',
                img:'',
                quantity:'1',
                category_id: ''
                
            },
            category_id: '',
            categories:[],
            sub_categories:[],
            sub_category_id: '',
            errors:{

            },
            source:'/product',
            upload_source:'/product',
            isFetchProduct: false,
        }
    },
    beforeMount(){

      if(this.$route.meta.tag == 'edit'){
        this.source=`/product/${this.$route.params.pid}/edit`;
        this.upload_source='/product/'+this.$route.params.pid;
        this.method = 'put'
        this.fetchProduct();
      }else{
        this.fetchCategoryList().then(()=>{
                $(".selectpicker").selectpicker("refresh");
        });
      }
        // this.editProduct();
        // this.fetchCategoryList();
        
    }
    ,
    mounted(){
                    // this.category_id =  5;

    },
    methods:{
        imgChg(e){
            var fr=new FileReader()
            fr.readAsDataURL(e.target.files[0])
            fr.onload=(e)=>{
                this.form.img=e.target.result
            }
        },
        upload(){
            this.form.category_id = this.sub_category_id|| this.category_id;
            this.axios[this.method](`${this.upload_source}`,this.form)
            .then(({data})=>{this.$swal(data[0]);this.$router.push({name:'mysell'});})
            .catch((error)=>console.log(this.errors=error.response.data))
        },
        fetchCategoryList(){
           return   this.axios.get('/categorylist')
              .then(({data})=>{
                this.categories=data


                // this.selectCategory();
                  // $(".selectpicker").selectpicker("refresh");
            })
          },
          fetchProduct(){

            var that =this;
            this.fetchCategoryList().then(function(){
              that.axios.get(that.source)
              .then(({data})=>{
                  if(data){
                    that.isFetchProduct = true;
                    that.form = data;
                        // that.category_id =  5;

                    if(data.category.parent_id){
                      that.category_id =  data.category.parent_id;
                    }else{
                        that.category_id =  data.category_id;
                    }
                    
                  }
                  return data
              }).then((data)=>{
                that.fetchSubCategoryList().then(function(){
                      that.sub_category_id = data.category_id
                }).then(()=>{
                      $(".selectpicker").selectpicker("refresh");
                  
                })
              })
            })
                // this.upload_source='/product/'+this.$route.params.pid
                // this.method='put'
                // this.form =  this.$store.state.products.edit_product;
                // this.axios.get('/categorylist')
                //   .then(({data})=>{
                //     this.categories=data
                //     this.selectCategory();
                // })
          },

          fetchSubCategoryList(){
            console.log(this.category_id)
            return  this.axios.get(`/sub_categorylist?id=${this.category_id}`)
              .then(({data})=>{
                this.sub_categories = data;
                return data;
            })
          },
          selectSubCategory(){
            // this.form.category_id = this.sub_category_id;
          },
          selectCategory(){
            this.sub_categories = [];
            this.sub_category_id = '';
            this.form.category_id = this.category_id;

            this.fetchSubCategoryList().then(()=>{
                $(".selectpicker").selectpicker("refresh");
            });

            // if(this.$route.meta.tag == 'create'){
            //   this.form.category_id = this.category_id;
            // }
          },
     
    },
   }

</script>
