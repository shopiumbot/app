<?php

namespace api\modules\v1\models;


use app\modules\cart\models\OrderProduct as BaseOrderProduct;


class OrderProduct extends BaseOrderProduct
{


    public function fields()
    {
        return [
            'id',
            'product_id',
            'sku',
            'quantity',
            'name',
            'price',
        ];
    }

    public function extraFields()
    {
        return ['originalProduct'];
    }
}
