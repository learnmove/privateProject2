<template>
  <div>
         <ul class="pagination">
            <li><a href=""  @click.prevent="changePage(1)"> <<</a></li> 
         <li :class="{'active':start==page}" v-for="start in pages" class="page-item" >
        <a href="#" @click.prevent="changePage(start)"> {{start}}</a>
        </li>
         <li><a href=""  @click.prevent="changePage(last_page)">>></a></li> 
        
        
    </ul>
  </div>
</template>
<script>
   import {mapState} from 'vuex'
    export default{
        props:['last_page','keyword','selectCategoryID','method_name','passpage','selectSchoolID'],
        data(){
            return{
               page:1,
               page_start:1,
               page_end:10,
            }
        },
        update(){
            if(this.passpage){
                this.page=this.passpage
            }
        },
        methods:{
             changePage(n){
            this.page=n
            this.$router.push({ path: 'product', query: { page: n }})
            this.$emit('fetchProducts',{page:n,method_name:this.method_name,selectSchoolID:this.selectSchoolID,category_id:this.selectCategoryID,keyword:this.keyword})
            if(this.last_page<10){
                this.page_start=1,
               this.page_end=this.last_page
            }else{
            if(n>5){
               this.page_start=n-4
               if(n+5>this.last_page){
                   this.page_end=this.last_page
               }else{
               this.page_end=n+5
               }
            }else{
                 this.page_start=1,
               this.page_end=10
            }
            }
            
        },
        watch_method(){
            if(this.last_page<10){
              this.page_start=1,
               this.page_end=this.last_page
            }else{
               this.page_end=10
                
            }
        }
    },
    watch:{
        'last_page':function(){
            this.watch_method()
        },
        'method_name':function(){
            this.changePage(1)
        },
        'passpage':function(){
                this.page=this.passpage
            
        }
    },
    computed:{
        pages(){
           let  arrayp=new Array()
           for(let i=this.page_start;i<=this.page_end;i++){
               arrayp.push(i)
           }
           return arrayp
        }
    }
    }

</script>
