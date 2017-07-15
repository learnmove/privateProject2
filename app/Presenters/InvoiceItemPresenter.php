<?php

namespace App\Presenters;

use App\Transformers\InvoiceItemTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class InvoiceItemPresenter
 *
 * @package namespace App\Presenters;
 */
class InvoiceItemPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new InvoiceItemTransformer();
    }
}
