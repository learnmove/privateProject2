<template>
  <div>
         <ul class="pagination">
             
         <li :class="{'active':start==page}" v-for="start in pages" class="page-item" >
        <a href="#" @click.prevent="changePage(start)"> {{start}}</a>
        </li>
        
    </ul>
  </div>
</template>
<script>
   import {mapState} from 'vuex'
    export default{
        props:['last_page'],
        data(){
            return{
               page:1,
               page_start:1,
               page_end:10,
            }
        },
     
        methods:{
             changePage(n){
            this.page=n
            this.$emit('fetchProducts',n)
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
        },
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
