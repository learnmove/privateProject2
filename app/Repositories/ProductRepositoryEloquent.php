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
         $model=$this->model->with('user')->orderBy('created_at','desc')->where('qty','>','0')->where('visible','<>','0')->paginate($per_page);

            break;
            case 'selectSchoolID':
         $model=$this->model->with('user')->orderBy('created_at','desc')
         ->where('qty','>','0')
         ->where('visible','<>','0')
         ->where('school_id',$request->selectSchoolID)
         ->paginate($per_page);
            break;
                
        }
        return $model;
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
    public function createProduct($product){
        $product['user_id']=JWTAuth::parseToken()->authenticate()->id;
       $product= $this->model->create($product);
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
    
    public function updateProduct($id,$product){
        $old_product=$this->model->find($id);
        $old_product->update($product);
        return '更新成功';
    }
}
