<template>
  <div class="container">
    <div class="col-sm-12 col-md-12 col-xs-12">
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
          <button @click="deleteProduct(product)" class="btn btn-danger">x</button>
          <router-link tag="button" class="btn btn-primary" :to="{name:'product_edit',params:{pid:product.id}}">俢改</router-link>
        </div>
        <img class="img-responsive prodcut_img"  :src="product.img" alt="">
        <div class="caption">
          <h3>{{product.name}}</h3>
          <p>{{product.description}}</p>
          <span class="text-waring" style="font-size:1rem;color: rgb(238, 77, 45);">${{product.price}} </span>
          <div class="">數量{{product.quantity}} </div>
          <div class="">賣家：<router-link :to="{name:'userstore',params:{'user_account':product.user.account}}">{{product.user.account}}</router-link>
          </div>
          <div v-if="product.user_id!=$auth.getUser().id" class="">
            選擇數量<select v-model.number="product.purchaseQty" value="1">
              <option :value=n v-for="n in product.quantity">{{n}}</option>
            </select>
          </div>
          <div class="">
            <a href="#" @click.prevent="purchase(product)" class="btn btn-default" role="button" v-if="product.user_id!=$auth.getUserId()">放進購物車</a></p>
            <button class="btn btn-primary" @click="showinput(product)">詢問/商品留言</button>
            <button class="btn btn-danger" @click="chat_select(product.user)" v-if="product.user_id!=$auth.getUserId()">聊聊</button>
          </div>
        </div>
      </div>
    </div>
    <h1 class="text-center">店家推薦</h1>
    <section>
      <div class="col-xs-3" style="background: white;padding-left: 10px" v-for="product in recommand_products">
          <router-link tag="a" style="background: white;border-color: white"  :to="{name:'product_',params:{pid:product.id}}">
            <img :src="product.img" alt="" class="recommand_img img-responsive">
            <div class="caption">
              <p style="  text-overflow: ellipsis;">{{product.name}}</p>
              <span class="text-waring" style="font-size:1rem;color: rgb(238, 77, 45);">${{product.price}} </span>
            

            
          </div>
          </router-link>

      </div>
      
    </section>
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
  </div>
</template>
<script>
import { mapActions, mapGetters, mapState } from 'vuex'
import pagination from '@/components/pagination.vue'
import modal from '@/components/plugin/Modal.vue'
import Vue from 'vue';
export default {

  beforeMount() {
    this.fetchProduct(this.$route.params.pid);
    console.log(this.product)
    // this.fetchSchoolList()
    // this.fetchCategoryList()
  },
  mounted(){

  },
  data() {
    return {
      method_name: 'fetchProducts',
      OpenModal: false,
      questions: [{}],
      question_info: {},
      question_page: '',
      queryingInfo: {},
      question_content: '',
      selectProduct: {},
      page_length: '10',
      schools: [],
      categories: [],
      selectCategoryID: '',
      selectSchoolID: '',
      keyword: '',

      fetchProducts_params: { page: 1, method_name: 'fetchProducts', selectSchoolID: '', category_id: '', keyword: '' }

    }
  },

  methods: {
    chat_select(user) {
      if (this.$auth.getUser()) {
        this.$store.dispatch('chat/setUser', user.id).then(() => {
          this.axios.post('/addChatUser', { chat_id: user.id })
            .then(({ data }) => {
              this.$router.push({ name: 'chat' })
            })
        })

      } else {
        this.$swal('請先登陸')
      }

    },
    clearCategory() {
      this.selectCategoryID = ''
      this.queryingInfo.category_name = ''
      this.fetchProducts({ page: 1, method_name: this.method_name, selectSchoolID: this.selectSchoolID, category_id: this.selectCategoryID })
    },
    sendQuestion() {
      if (this.$auth.getUser()) {
        this.axios.post(`/question`, { product_id: this.selectProduct.id, account: this.$auth.getUser().account, content: this.question_content, seller_id: this.selectProduct.user_id })
          .then(({ data }) => {
            this.$swal(data)
            this.questions.unshift({
              account: this.$auth.getUser().account,
              content: this.question_content,
              created_at: "1 秒前"
            })
            this.question_content = ''
            // this.fetchQuestion(this.selectProduct)
          })
      } else {
        this.$swal('請先登入')
      }
    },
    searchProduct() {
      this.fetchProducts({ page: 1, method_name: this.method_name, selectSchoolID: this.selectSchoolID, category_id: this.selectCategoryID, keyword: this.keyword })
    },
    selectCategory(id, category_name) {
      this.queryingInfo.category_name = category_name
      this.fetchProducts({ page: 1, category_id: id })
    },
    selectSchool(id, school_name) {

      this.queryingInfo.school_name = school_name
      this.fetchProducts({ page: 1, selectSchoolID: id, category_id: '' })
    },
    fetchSchoolList() {
      this.axios.get('/schoolist')
        .then(({ data }) => { this.schools = data })
    },
    fetchCategoryList() {
      this.axios.get('/categorylist')
        .then(({ data }) => { this.categories = data })
    },
    questionPage(pagination) {
      this.question_page = pagination.page

      this.fetchQuestion(this.selectProduct)

    },
    cancel() {
      this.OpenModal = false
    },
    showinput(product) {
      this.question_page = 1

      this.OpenModal = !this.OpenModal
      if (this.OpenModal == true) {
        this.fetchQuestion(product)
      }
    },
    fetchQuestion(product) {
      this.selectProduct = product
      this.axios.get(`/question/${product.id}?page=${this.question_page}`)
        .then(({ data }) => {
          this.questions = data.data
          delete data.data
          this.question_info = data
        })
    },
    //   ...mapActions('products',['fetchProducts'],this.page)
    changePage(page, method_name) {
      this[method_name]({ page: page });
    },
    fetchProduct(id) {
      this.$store.dispatch('products/fetchProduct', id)
    },
    fetchProducts(user_id) {
      console.log(user_id)
      this.$store.dispatch('products/fetchRecommandProducts', user_id)
    },
    deleteProduct(product) {
      const that = this;
      this.$swal({
        title: "確定要刪除?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes,刪了它吧!",
        cancelButtonText: "No, 我按錯了!",
      }).then(function() {
        that.$store.dispatch('products/deleteProduct', product)
        that.$swal('刪了')
      });
    },
    purchase(product) {
      if (this.$auth.isAuthenticate()) {
        if (product.purchaseQty) {
          this.$store.dispatch('cart/addItem', product)
          this.$swal('放進去了')
        } else {
          this.$swal('你沒選數量')
        }

      } else {
        this.$swal('請先登入')
      }
    }
  },
  computed: {
    //   ...mapGetters('products',['getProducts'])
    ...mapState('products', ['product', 'recommand_products'])
  },
  components: {
    pagination,
    modal
  }
}

</script>
<style>
  .prodcut_img{
    max-height: 1082px;
  }
  .recommand_img{
    max-height: 260px;
  }
</style>