<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\invoiceItemRepository;
use App\Entities\InvoiceItem;
use App\Validators\InvoiceItemValidator;
use App\Entities\Product;
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
    public function createItem($invoice,$items, $userID){
        $Invoiceitems=[];
        foreach($items as $item){
            $item['product_id']=$item['id'];
            $item['item_total_price']=$item['itemTotal'];
            $item['item_total_qty']=$item['qty'];
            $product=$this->updateProductQty($item);
            $item['seller_id']=$product->user->id;
            $item['buyer_id']=$userID;
            $Invoiceitems[]=$item;
        }
        $invoice->items()->createMany($Invoiceitems);
        foreach($invoice->items as $item){
            $item->itemStatus()->attach(1);
        }
        return $invoice->items;
    
    }
    public function updateProductQty($item){
        
        $product=Product::with('user')->find($item['id']);
        $restQty=$product->qty-$item['qty'];
        $product->update(['qty'=>$restQty]);
        return $product;
    }
    
    
}
