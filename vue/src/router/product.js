
import ProductForm from '@/components/product/form'
import ProductIndex from '@/components/product/index'
import Cart from '@/components/product/cart'
import Order from '@/components/product/order'
import Seller from '@/components/product/mysell'
import MySellOut from '@/components/product/sellout'
import UserStore from '@/components/product/userstore'
import UserRating from '@/components/product/rating'
import Product from '@/components/product/product'



 const product=[
{
    name:'product',
    component:ProductIndex,
    path:'/product'
 },
 {
    name:'product_create',
    component:ProductForm,
    path:'/product/create',
    meta:{forAuth:true, tag: 'create'}

 },
 {
    name: 'product_',
    component: Product,
    path: '/product/:pid'
 },
 {
    name:'product_edit',
    component:ProductForm,
    path:'/product/:pid/edit',
    meta:{forAuth:true, tag: 'edit'}

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
     path:'/master/my/order',
     meta:{forAuth:true}
 },
  {
     name:'mysell',
     component:Seller,
     path:'/master/my/mysell',
     meta:{forAuth:true}
 },  {
     name:'sellout',
     component:MySellOut,
     path:'/master/my/sellout',
     meta:{forAuth:true}
 },
  {
     name:'user_ratting',
     component:UserRating,
     path:'/product/rating/:user_account'

 },
 {
     name:'userstore',
     component: UserStore,
     path:'/:user_account'
 }


 
 
 ]
export default product