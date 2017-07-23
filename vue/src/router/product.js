
import Product_Form from '@/components/product/form'
import Product_Index from '@/components/product/index'
import Cart from '@/components/product/cart'
import Order from '@/components/product/order'
import Seller from '@/components/product/mysell'
import MySellOut from '@/components/product/sellout'
import UserStore from '@/components/product/userstore'
import UserRating from '@/components/product/rating'


 const product=[
{
    name:'product',
    component:Product_Index,
    path:'/product'
 },
 {
    name:'product_create',
    component:Product_Form,
    path:'/product/create',
    meta:{forAuth:true,create:true}

 },
 {
    name:'product_edit',
    component:Product_Form,
    path:'/product/:pid/edit',
    meta:{forAuth:true,edit:true}

 },
 {
     name:'cart',
     component:Cart,
     path:'/product/cart',
     meta:{forAuth:true}
 },
 {
     name:'order',
     component:Order,
     path:'/product/order',
     meta:{forAuth:true}
 },
  {
     name:'mysell',
     component:Seller,
     path:'/product/mysell',
     meta:{forAuth:true}
 },  {
     name:'sellout',
     component:MySellOut,
     path:'/product/sellout',
     meta:{forAuth:true}
 },
  {
     name:'user_ratting',
     component:UserRating,
     path:'/product/rating/:user_account'

 },
 {
     name:'userstore',
     component:UserStore,
     path:'/product/:user_account'
 }


 
 
 ]
export default product