<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProductQuestionRepository;
use App\Entities\ProductQuestion;
use App\Validators\ProductQuestionValidator;

/**
 * Class ProductQuestionRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ProductQuestionRepositoryEloquent extends BaseRepository implements ProductQuestionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductQuestion::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function FindProductIdQuestion($product_id){
      return  $this->model->where('product_id',$product_id)->latest()->paginate(1);
    }
}
