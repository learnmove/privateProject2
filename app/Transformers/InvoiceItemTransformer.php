<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\InvoiceItem;

/**
 * Class InvoiceItemTransformer
 * @package namespace App\Transformers;
 */
class InvoiceItemTransformer extends TransformerAbstract
{

    /**
     * Transform the \InvoiceItem entity
     * @param \InvoiceItem $model
     *
     * @return array
     */
    public function transform(InvoiceItem $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
