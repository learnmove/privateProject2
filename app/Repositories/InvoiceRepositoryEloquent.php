<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\invoiceRepository;
use App\Entities\Invoice;
use App\Validators\InvoiceValidator;
use JWTAuth;
/**
 * Class InvoiceRepositoryEloquent
 * @package namespace App\Repositories;
 */
class InvoiceRepositoryEloquent extends BaseRepository implements InvoiceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Invoice::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function createInvoice($invoice){
        $invoice_result=$this->model->create($invoice);
        return $invoice_result;
    }
    public function findInvoiceOfItems($userid){
        $user_invoice=$this->model->with('items','items.itemStatus')->where('user_id',$userid)->orderBy('created_at','desc')->get();

        return $user_invoice;
    }
}
