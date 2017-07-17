<?php
namespace App\Services;
use App\Entities\InvoiceItem;
class InvoiceItemService{
   public function changeItemStatus($status,$id,$userID)
   {
       $item=InvoiceItem::find($id);
      if($status==8||$status==10){
        $item->itemStatus()->attach($status,['requester_id'=>$userID]);

      }else{
        $item->itemStatus()->attach($status);

      }
       return $item->itemStatus()->first();
      
  
   }
}