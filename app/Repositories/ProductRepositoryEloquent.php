<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProductRepository;
use App\Validators\ProductValidator;
use JWTAuth;
use App\Entities\InvoiceItem;
use App\Entities\Product;

use App\Entities\User;
use DB;
use App\Services\ProductService;

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
    public function withMeAndPage($per_page,$userID){
        $request=request();
        $method_name=$request->method_name;
            switch ($method_name){
            case 'fetchMyProducts':
            $model= Product::with('user','category')->where('user_id',$userID)->where('is_visible','<>','0')->orderBy('created_at','desc')->paginate($per_page);
            break;
            case 'sellout':
            $model= Product::with('user','category')->where('user_id',$userID)->where('quantity',0)->orderBy('created_at','desc')->paginate($per_page);
            break;
        }
    
        return $model;
    }
    public function withInfoAndPageOfUser($per_page,$user_account){
        $user=User::where('account',$user_account)->first();
        $user_id=$user->id;
        $countRateOfUser=$this->countRateOfUser($user_id);
        $countProduct=$this->countProductOfUser($user_id);
        $model= Product::with('user')->where('user_id',$user_id)->where('quantity','<>',0)->where('is_visible','<>','0')->orderBy('created_at','desc')->paginate($per_page);
        return ['model'=>$model,'store_info'=> ['countProduct'=>$countProduct,'user'=>$user,'countRateOfUser'=>$countRateOfUser]];
    }
    public function countProductOfUser($user_id){
        return  Product::where('user_id',$user_id)->count();
    }
    public function countRateOfUser($user_id){
        return InvoiceItem::has('rating')->where('seller_id',$user_id)->count();
    }
    // public function destroypProduct($id){
    //      Product::destroy($id);
    //     return '刪除成功';
    // }
}
