<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProductRepository;
use App\Entities\Product;
use App\Validators\ProductValidator;
use JWTAuth;
use App\Entities\InvoiceItem;
use App\Entities\User;
use DB;
/**
 * Class ProductRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ProductRepositoryEloquent extends BaseRepository implements ProductRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
    }
  

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function withUserAndPage($per_page){
        $request=request();
        switch($request->method_name){

            case 'fetchProducts':
            if($request->category_id){
               $model=  $this->haveCategoryProduct($request->category_id,$per_page);
            }else{
             $model=$this->model->with('user','categories','school')->orderBy('created_at','desc')->where('qty','>','0')->where('visible','<>','0')->search($request->keyword)->paginate($per_page);

            }

            break;
            case 'selectSchoolID':
            if($request->category_id){
               $model=  $this->haveCategorySchoolProduct($request->selectSchoolID,$request->category_id,$per_page);
            }else{
        $model=$this->model->with('user','categories','school')->orderBy('created_at','desc')
         ->where('qty','>','0')
         ->where('visible','<>','0')
         ->where('school_id',$request->selectSchoolID)
         ->search($request->keyword)
         ->paginate($per_page);
            }

            break;
                
        }
        return $model;
    }

    public function haveCategorySchoolProduct($school_id=null,$category_id,$per_page){
        $request=request();
        $categoryItems=DB::table('product_category')
        ->where('school_id',$school_id)
        ->where('category_id',$category_id)
        ->get();
        $categoryItemsID=[];
        foreach($categoryItems as $categoryItem){
             $categoryItemsID[]=$categoryItem->product_id;
        }
        
      return  $this->model->with('user','categories','school')
        ->whereIn('id',$categoryItemsID)
         ->where('qty','>','0')
         ->where('visible','<>','0')
         ->where('school_id',$request->selectSchoolID)
         ->search($request->keyword)
         ->paginate($per_page);
    }
    public function haveCategoryProduct($category_id,$per_page){
        $request=request();
        $categoryItems=DB::table('product_category')
        ->where('category_id',$category_id)
        ->get();
        $categoryItemsID=[];
        foreach($categoryItems as $categoryItem){
             $categoryItemsID[]=$categoryItem->product_id;
        }
      return  $this->model->with('user','categories','school')
        ->whereIn('id',$categoryItemsID)
         ->where('qty','>','0')
         ->where('visible','<>','0')
         ->search($request->keyword)
         ->paginate($per_page);
    }
    public function withMeAndPage($per_page,$userID){
        $request=request();
        $method_name=$request->method_name;
            switch ($method_name){
            case 'fetchMyProducts':
            $model=$this->model->with('user')->where('user_id',$userID)->where('visible','<>','0')->orderBy('created_at','desc')->paginate($per_page);
            break;
            case 'sellout':
            $model=$this->model->with('user')->where('user_id',$userID)->where('qty',0)->orderBy('created_at','desc')->paginate($per_page);
            break;
        }
    
        return $model;
    }
    public function withInfoAndPageOfUser($per_page,$user_account){
        $user=User::where('account',$user_account)->first();
        $user_id=$user->id;
        $countRateOfUser=$this->countRateOfUser($user_id);
        $countProduct=$this->countProductOfUser($user_id);
        $model=$this->model->with('user')->where('user_id',$user_id)->where('qty','<>',0)->where('visible','<>','0')->orderBy('created_at','desc')->paginate($per_page);
        return ['model'=>$model,'store_info'=> ['countProduct'=>$countProduct,'user'=>$user,'countRateOfUser'=>$countRateOfUser]];
    }
    public function countProductOfUser($user_id){
        return $this->model->where('user_id',$user_id)->count();
    }
    public function countRateOfUser($user_id){
        return InvoiceItem::has('rating')->where('seller_id',$user_id)->count();
    }
    public function createProduct($request){
        $product=$request->except('category_id');
        $product['user_id']=JWTAuth::parseToken()->authenticate()->id;
        $product['school_id']=$school_id=JWTAuth::parseToken()->authenticate()->school_id;
       $product= $this->model->create($product);
       $product->categories()->attach($request->category_id,['school_id'=>$school_id]);
        return $product;
    }
    // public function destroypProduct($id){
    //     $this->model->destroy($id);
    //     return '刪除成功';
    // }
    public function softDeleteStatus($id){
        $product=$this->model->find($id);
        $product->visible=0;
        $product->save();
        return '刪除成功';
    }
    
    public function updateProduct($id,$request){
        $school_id=JWTAuth::parseToken()->authenticate()->school_id;
          $product=$request->except('category_id');
        $old_product=$this->model->find($id);
        DB::table('product_category')->where('product_id',$id)->update(['category_id'=>$request->category_id]);
        // $old_product->categories()->attach($request->category_id,['school_id'=>$school_id]);
        $new_product=$old_product->update($product);
        return '更新成功';
    }
}
