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
                    </div>
                      <div class="form-group" >
                        <div class="col-sm-2">
                            <label for="">分類</label>
                            
                        </div>
                        <div class="col-sm-10">
                        <select class="selectpicker" @change="fetchSubCategoryList()" v-model="category_id">
                            <option v-for="category in categories" :value="category.id" >{{category.name}}</option>
                        
                            </select>

                        </div>
                    </div>
                      <div class="form-group" >
                        <div class="col-sm-2">
                            <label for="">子分類</label>
                            
                        </div>
                        <div class="col-sm-10">
                        <select class="selectpicker" v-model="sub_category_id" >
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
                category_id: 1
                
            },
            category_id: '1',
            categories:[],
            sub_categories:[],
            sub_category_id: '',
            errors:{

            },
            source:'/product',
            upload_source:'/product'
        }
    },
    beforeMount(){
        if(this.$route.meta.tag == 'edit'){
            this.editProduct();
        }else{
            this.fetchCategoryList();
        }
        
    }
    ,
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
            .then(({data})=>{this.$swal(data[0]);this.$router.push({name:'product'});})
            .catch((error)=>console.log(this.errors=error.response.data))
        },
        fetchCategoryList(){

              this.axios.get('/categorylist')
              .then(({data})=>{
                this.categories=data
                this.fetchSubCategoryList();
                setTimeout(function(){
                  $(".selectpicker").selectpicker("refresh");
                }, 0)
            })
          },
          editProduct(){
            this.source=`/product/${this.$route.params.pid}/edit`
            this.$store.dispatch('products/editProduct',this.source).then(()=>{
                this.upload_source='/product/'+this.$route.params.pid
                this.method='put'
                this.form =  this.$store.state.products.edit_product;
                this.axios.get('/categorylist')
                  .then(({data})=>{
                    if(this.$store.state.products.edit_product.category.parent_id){
                        this.category_id =  this.$store.state.products.edit_product.category.parent_id;
                    }else{
                        this.category_id =  this.$store.state.products.edit_product.category_id;
                    }
                    this.categories=data
                    this.fetchSubCategoryList();
                    setTimeout(function(){
                      $(".selectpicker").selectpicker("refresh");
                    }, 0)
                })
            })
          },
          fetchSubCategoryList(){
            if(this.$route.meta.tag == 'create'){
              this.form.category_id = this.category_id;
            }
              this.sub_category_id = '';
              this.sub_categories = [];
              setTimeout(function(){
                $(".selectpicker").selectpicker("refresh");
              }, 0)
              this.axios.get(`/sub_categorylist?id=${this.category_id}`)
              .then(({data})=>{
                if(data){
                    if(this.$route.meta.tag =='edit'){
                        this.sub_category_id = this.$store.state.products.edit_product.category_id || '';
                    }else{
                        this.sub_category_id = data[0].id;
                    }
                    this.form.category_id = this.sub_category_id;
                    this.sub_categories=data
                }


                setTimeout(function(){
                  $(".selectpicker").selectpicker("refresh");
                }, 0)
            })
          },
     
    },
   }

</script>
