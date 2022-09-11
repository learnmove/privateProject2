<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\invoiceRepository;
use App\Entities\Invoice;
use App\Entities\InvoiceItem;
use App\Validators\InvoiceValidator;
use JWTAuth;
use DB;
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

    public function presenter()
    {
        return "App\\Presenters\\InvoicePresenter";
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
    public function findInvoiceOfItems(){
        $request=request();
        $user_invoice='';
        switch($request->method_name){
            case 'buy_list':
             $user_invoice=$this->getInvoiceOfItems();
            break;            
            case 'trade_complete':
            $user_invoice=$this->getInvoiceOfStatusItems([12]);
            break;
            case 'buyrefund':
            $user_invoice=$this->getInvoiceOfStatusItems([14,11,10]);
            break;
               case 'buycancell':
            $user_invoice=$this->getInvoiceOfStatusItems([8,9]);
            break;
            default:
        }
        return $user_invoice;
        
        }

    public function getInvoiceOfItems(){
        $user_id=JWTAuth::parseToken()->authenticate()->id;

        $user_invoice=InvoiceItem::with([
        'order_status' ,'pay_type', 'product','product.user','rating','rating_comment'])
        ->where('buyer_id',$user_id)
        ->orderBy('created_at','desc')
        // ->get();
        ->paginate(3);
        return $user_invoice;
    }
    public function getInvoiceOfStatusItems($status_id){
        $user_id=JWTAuth::parseToken()->authenticate()->id;

        $invoices=$this->model->where('user_id', $user_id)->get();
        $invoiceID=[];
        foreach($invoices as $invoice){
            $invoiceID[]=$invoice->id;
        }
        $items = InvoiceItem::with([
        'order_status' ,'pay_type', 'product','product.user','rating','rating_comment'])->whereIn('order_status_id', $status_id)
        ->paginate(3);
        
        return $items;
    }
    public function getInvoiceOfRefundItems($userid){
        return $user_invoice=$this->model
        ->with(['items',
        'items.itemStatus','items.product','items.product.user','items.rating','items.rating_comment'])
        ->whereHas('items.itemStatus',function($q){
        $q->whereIn('event',['refunded'])
        ;
        })
        ->where('user_id',$userid)
        ->orderBy('created_at','desc')
        // ->get();
        ->paginate(3);
    }
}
