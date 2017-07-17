<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RatingCommentRepository;
use App\Entities\RatingComment;
use App\Validators\RatingCommentValidator;

/**
 * Class RatingCommentRepositoryEloquent
 * @package namespace App\Repositories;
 */
class RatingCommentRepositoryEloquent extends BaseRepository implements RatingCommentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RatingComment::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
