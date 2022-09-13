<template>
  <div>
         <ul class="pagination">
            <li><a href=""  @click.prevent="changePage(1)"> <<</a></li> 
         <li :class="{'active':start== page}" v-for="start in pages" class="page-item" >
        <a href="#" @click.prevent="changePage(start)"> {{start}}</a>
        </li>
         <li><a href=""  @click.prevent="changePage(last_page)">>></a></li> 
        
    </ul>
  </div>
</template>
<script>
   import {mapState} from 'vuex'
    export default{
        props:['last_page','method_name','passpage', 'current_page', 'page_length', 'page'],
        data(){
            return{
               page_start:1,
               page_end:10,
            }
        },
        methods:{
             changePage(n){
            this.$emit('changePage', n, this.method_name);
        },
    },
    computed:{
        pages(){
           let  arr=new Array()
           this.page_start = this.page -4;
           if(this.page_start <= 0){
             this.page_start = 1;
           }

           this.page_end = parseInt(this.page)  +4
           if((parseInt(this.page) + 4 ) < this.last_page && this.last_page < 10){this.page_end = this.last_page;}

           if(this.page_end < 10 && this.last_page > 10){
             this.page_end = 10
           }
           if(this.page_end > this.last_page){
            this.page_end = this.last_page
          }
          

           for(let i=this.page_start;i<=this.page_end;i++){
               arr.push(i)
           }
           return arr
        }
    }
    }

</script>
