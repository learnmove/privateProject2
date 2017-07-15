<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProductRepository;
use App\Entities\Product;
use App\Validators\ProductValidator;
use JWTAuth;
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
        $model=$this->model->with('user')->orderBy('created_at','desc')->where('qty','>','0')->paginate($per_page);
        return $model;
    }
    public function createProduct($product){
        $product['user_id']=JWTAuth::parseToken()->authenticate()->id;
       $product= $this->model->create($product);
        return $product;
    }
    public function destroypProduct($id){
        $this->model->destroy($id);
        return '刪除成功';
    }
    public function updateProduct($id,$product){
        $old_product=$this->model->find($id);
        $old_product->update($product);
        return '更新成功';
    }
}
