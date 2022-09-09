<template>
   <div class="container">
      <div class="row">
         <div class="form-group">
            搜尋 <input type="text" name="" id="" v-model="keyword">
            <button class="btn btn-primary" @click="searchProduct"><i class="fa fa-search" aria-hidden="true"></i>
            </button>
         </div>
      </div>
      <div class="row">
         <pagination :method_name="method_name" @changePage="changePage"  :last_page="products.last_page" :page="this.fetchProducts_params.page" :page_length="'10'"></pagination>
      </div>
      <button class="btn btn-info" v-if="$auth.isAuthenticate()"  @click.prevent="selectSchool($auth.getUserSchoolId())">我的學校</button>
      <div class="dropdown">
         
         <select name=""  data-live-search="true"  class="selectpicker"  @change="selectSchool()" v-model="school_id" >
          <option value="0" selected="selected">全部學校</option>
           <option v-for="school in schools" :value="school.id">{{school.name}}</option>

         </select>
         
         <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
         </ul>
      </div>
      <div class="dropdown">

            
            <select name="" id="" v-model="category_id" @change="selectCategory()" class="form-control">
              <option value="0">全部</option>

              <option v-for="category in categories" :value="category.id">{{category.name}} </option>
              
            </select>
         <ul class="dropdown-menu">
            <li ></li>
         </ul>
      </div>
      <div class="dropdown">
         <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">分類
         <span class="caret"></span></button>
         <ul class="dropdown-menu">
            <li ><a href="#" @click="fetchProducts({page: 1, category_id:category_id})">全部</a></li>
            <li v-for="sub_category in sub_categories"><a href="#" @click.prevent="selectCategory(sub_category.id)">{{sub_category.name}} </a></li>
         </ul>
      </div>
<!--       <ol class="breadcrumb">
         <li v-if="this.queryingInfo.school_name" class="breadcrumb-item"><a href="#">{{this.queryingInfo.school_name}}</a></li>
         <li v-if="this.queryingInfo.category_name" class="breadcrumb-item"><a href="#">{{this.queryingInfo.category_name}}</a></li>
      </ol> -->
      <div class="col-sm-4 col-md-4 col-xs-12 products" v-for="product in products.data">
        <router-link tag="a" style="background: white;border-color: white;text-decoration: none;"  :to="{name:'product_',params:{pid:product.id}}">
         <div class="thumbnail">
            <div class="category_name">
               【{{product.category.name}}】
            </div>
            <div class="school_name">
               {{product.school.name}}
            </div>
            <div class="updated_at">
               {{product.updated_at}}
            </div>
            <div v-if="product.user_id==$auth.getUser().id" class="text-right text-danger">
               <button @click.prevent="deleteProduct(product)" class="btn btn-danger">x</button>
               <router-link @click.prevent tag="button" class="btn btn-primary" :to="{name:'product_edit',params:{pid:product.id}}">俢改</router-link>
            </div>
            <router-link tag="a" style="background: white;border-color: white" class="btn btn-primary" :to="{name:'product_',params:{pid:product.id}}"><img style="max-height:260px;" class="img-responsive" :src="product.img" alt=""></router-link>
            <div class="caption">
               <h3>{{product.name}}</h3>
               <p class="description">{{product.description}}</p>
               <span class="text-waring" style="font-size:1rem;color: rgb(238, 77, 45);">${{product.price}} </span>
               <div class="">數量{{product.quantity}} </div>
               <div class="">
                  賣家：
                  <router-link :to="{name:'userstore',params:{'user_account':product.user.account}}">{{product.user.account}}</router-link>
               </div>
               <div v-if="product.user_id!=$auth.getUser().id" class="">
                  選擇數量
                  <select @click.prevent v-model.number="product.purchaseQty" value="1" >
                     <option :value=n v-for="n in product.quantity">{{n}}</option>
                  </select>
               </div>
               <div class="">
                  <a href="#" @click.prevent="purchase(product)" class="btn btn-default" role="button" v-if="product.user_id!=$auth.getUserId()">放進購物車</a></p>
                  <button class="btn btn-primary" @click.prevent="showinput(product)" >商品留言/{{product.questions_count}}則</button>
                  <button class="btn btn-danger" @click.prevent="chat_select(product.user)" v-if="product.user_id!=$auth.getUserId()">聊聊</button>
               </div>
            </div>
         </div>

        </router-link>
      </div>
      <div class="row">
         <!--<pagination :method_name="method_name" @fetchProducts="fetchProducts"  :last_page="products.last_page"></pagination>-->
         <modal title="Modal Title" :show="OpenModal" @cancel="cancel">
            <div class="form-group"><input type="text" name="" id="" v-model="question_content" class="form-control"></div>
            <button class="btn btn-primary" @click="sendQuestion">送出訊息</button>
            <div class="media" v-for="question in questions">
               <a class="media-left media-middle" href="#">
               </a>
               <div class="media-body">
                  <h4 class="media-heading">{{question.account}}</h4>
                  <div class="ask">
                     <div>
                        {{question.content}}
                     </div>
                  </div>
                  <div class="date">
                     {{question.created_at}}
                  </div>
               </div>
            </div>
            <pagination @fetchProducts="questionPage" :passpage="question_page" :last_page="question_info.last_page"></pagination>
         </modal>
      </div>
      <pagination :method_name="method_name" @changePage="changePage"  :last_page="products.last_page" :page="this.fetchProducts_params.page" :page_length="'10'"></pagination>
   </div>
</template>
<script>
import {mapActions,mapGetters,mapState} from 'vuex'
import pagination from'@/components/pagination.vue'
import modal from'@/components/plugin/Modal.vue'

    export default{
       
        beforeMount(){
            // this.fetchProducts_params query

            this.fetchProducts_params = {...this.fetchProducts_params,...this.$route.query};
            this.fetchProducts(this.fetchProducts_params)
            this.fetchSchoolList()
            this.fetchCategoryList()
        },
       
        data(){
            return{
                method_name:'fetchProducts',
                OpenModal:false,
                questions:[{}],
                question_info:{},
                question_page:'',
                 queryingInfo:{},
                question_content:'',
                selectProduct:{},
                page_length: '10',
                schools:[],
                categories:[],
                sub_categories:[],
                selectCategoryID:'',
                selectSchoolID:'',
                keyword:'',
                category_id: this.$route.query.category_id||'0',
                school_id: this.$route.query.selectSchoolID||'0',
                fetchProducts_params: {page:1,method_name:'fetchProducts',selectSchoolID:'',category_id:'',keyword:''}

            }
        },
      
      methods:{
          chat_select(user){

            if(this.$auth.getUser()){
                this.$store.dispatch('chat/setUser', user.id).then(()=>{
                 this.axios.post('/addChatUser',{chat_id:user.id})
                    .then(({data})=>{
                      this.$router.push({name:'chat'})
                  })
                })

            }else{
              this.$swal('請先登陸')
            }
            
          },
          clearCategory(){
            this.selectCategoryID=''
            this.queryingInfo.category_name=''
            this.fetchProducts({page:1,method_name:this.method_name,selectSchoolID:this.selectSchoolID,category_id:this.selectCategoryID})
          },
          sendQuestion(){
          if(this.$auth.getUser()){
                 this.axios.post(`/question`,{product_id:this.selectProduct.id,account:this.$auth.getUser().account,content:this.question_content,seller_id:this.selectProduct.user_id})
            .then(({data})=>{
                this.$swal(data) 
                this.questions.unshift({account:this.$auth.getUser().account,
content:this.question_content,
created_at:"1 秒前"})
                this.question_content=''
            // this.fetchQuestion(this.selectProduct)
        })
          }else{
            this.$swal('請先登入')
          }
          },
          searchProduct(){
            this.fetchProducts({page:1,method_name:this.method_name,selectSchoolID:this.selectSchoolID,category_id:this.selectCategoryID,keyword:this.keyword})
          }
          ,
          selectCategory(id){
            if(id){
              this.fetchProducts({page:1, category_id: id});
            }else{
              this.fetchProducts({page:1, category_id: this.category_id});
            }
            
            if(this.category_id == 0){
              this.fetchProducts({page: 1, category_id:''});
              return;
            }

            this.fetchSubCategoryList(this.category_id);

          },
          selectSchool(id){
            if(id){
              this.school_id = id;
            }
            if(this.school_id == 0){
              this.fetchProducts({page: 1,selectSchoolID:''});
              return;
            }
            // this.queryingInfo.school_name=school_name
            this.fetchProducts({page:1, selectSchoolID: this.school_id})
          },
          fetchSchoolList(){
              this.axios.get('/schoolist')
              .then(({data})=>{
                if(data){
                  this.schools=data
                  
                }

                setTimeout(function(){
                  // $(".selectpicker").selectpicker("refresh");
                }, 0)
              })
          },
          fetchCategoryList(){
              this.axios.get('/categorylist')
              .then(({data})=>{this.categories=data})
          },
          fetchSubCategoryList(id){

              this.axios.get(`/sub_categorylist?id=${id}`)
              .then(({data})=>{this.sub_categories=data})
          },
          questionPage(pagination){
            this.question_page=pagination.page
            
            this.fetchQuestion(this.selectProduct)
            
          },
          cancel(){
                this.OpenModal=false
          },
          showinput(product){
                this.question_page=1
              
            this.OpenModal=!this.OpenModal
            if(this.OpenModal==true){
            this.fetchQuestion(product)
            }
          },
          fetchQuestion(product){
              this.selectProduct=product
            this.axios.get(`/question/${product.id}?page=${this.question_page}`)
            .then(({data})=>{
                this.questions=data.data
                delete data.data
                this.question_info=data
            })
          }
          ,
        //   ...mapActions('products',['fetchProducts'],this.page)
        changePage(page,method_name){
          this[method_name]({page: page});
        },
        fetchProducts(fetchProducts_params){            
          this.fetchProducts_params = {...this.fetchProducts_params,...fetchProducts_params}

          this.$router.push({path: 'product', query: this.fetchProducts_params});

            return this.$store.dispatch('products/fetchProducts', this.fetchProducts_params)},
        deleteProduct(product){
            const that = this;
            this.$swal({
  title: "確定要刪除?",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "Yes,刪了它吧!",
  cancelButtonText: "No, 我按錯了!",
}).then(function(){
    that.$store.dispatch('products/deleteProduct',product)
    that.$swal('刪了')});
        },
        purchase(product){
            if(this.$auth.isAuthenticate()){
                if(product.purchaseQty){
                    this.$store.dispatch('cart/addItem',product)
                    this.$swal('放進去了')
                }else{
                    this.$swal('你沒選數量')
                }
            
            }else{
                this.$swal('請先登入')
            }
        }
      },
      computed:{
        //   ...mapGetters('products',['getProducts'])
        ...mapState('products',['products'])
      },
      components:{
          pagination,
          modal
      }
    }
</script>
<style>
  .prodcut_img{
    max-height: 260px;
  }
</style>