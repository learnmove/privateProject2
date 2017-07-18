<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RatingRepository;
use App\Entities\Rating;
use App\Validators\RatingValidator;
use App\Entities\User;
use App\Entities\InvoiceItem;

/**
 * Class RatingRepositoryEloquent
 * @package namespace App\Repositories;
 */
class RatingRepositoryEloquent extends BaseRepository implements RatingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Rating::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function getUserRating($user_account,$method_name){
      
        $user=User::where('account',$user_account)->first();
        $user_id=$user->id;
          switch($method_name){
            case 'fetchData':
            $ratings=InvoiceItem::with(['product','rating','rating.user','rating_comment'])->has('rating')->where('seller_id',$user_id)->paginate(10);
                break;
            case 'StarOne':
            $ratings=InvoiceItem::with(['product','rating','rating.user','rating_comment'])->whereHas('rating',function($q){$q->where('level',1);})->where('seller_id',$user_id)->paginate(10);
                break;
            case 'StarTwo':
            $ratings=InvoiceItem::with(['product','rating','rating.user','rating_comment'])->whereHas('rating',function($q){$q->where('level',2);})->where('seller_id',$user_id)->paginate(10);
                break;
            case 'StarThree':
            $ratings=InvoiceItem::with(['product','rating','rating.user','rating_comment'])->whereHas('rating',function($q){$q->where('level',3);})->where('seller_id',$user_id)->paginate(10);
                break;
             case 'StarFour':
            $ratings=InvoiceItem::with(['product','rating','rating.user','rating_comment'])->whereHas('rating',function($q){$q->where('level',4);})->where('seller_id',$user_id)->paginate(10);
                break;
             case 'StarFive':
            $ratings=InvoiceItem::with(['product','rating','rating.user','rating_comment'])->whereHas('rating',function($q){$q->where('level',5);})->where('seller_id',$user_id)->paginate(10);
                break;
        }
       return $ratings;
    }

}
