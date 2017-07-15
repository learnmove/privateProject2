<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\invoiceItemRepository;
use App\Entities\InvoiceItem;
use App\Validators\InvoiceItemValidator;

/**
 * Class InvoiceItemRepositoryEloquent
 * @package namespace App\Repositories;
 */
class InvoiceItemRepositoryEloquent extends BaseRepository implements InvoiceItemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return InvoiceItem::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
