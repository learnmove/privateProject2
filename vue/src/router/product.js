
import Product_Form from '@/components/product/form'
import Product_Index from '@/components/product/index'
import Cart from '@/components/product/cart'

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
 }

 
 
 ]
export default product