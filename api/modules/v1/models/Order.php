<?php

namespace api\modules\v1\models;


use app\modules\cart\models\Order as BaseOrder;


class Order extends BaseOrder
{

    public function fields()
    {
        return [
            'id',
            'status_id',
            'total_price',
            'customer' => function ($model) {

                $data['name'] = $model->user_name;
                $data['phone'] = $model->user_phone;
                $data['email'] = $model->user_email;
                if ($model->user_address)
                    $data['address'] = $model->user_address;
                if ($model->user_comment)
                    $data['comment'] = $model->user_comment;

                return $data;
            },
            'delivery' => function ($model) {
                return [
                    'id' => $model->delivery_id,
                    'name' => $model->deliveryMethod->name,
                ];
            },
            'payment' => function ($model) {
                return [
                    'id' => $model->payment_id,
                    'name' => $model->paymentMethod->name,
                ];
            },
            'products' => function ($model) {
                return $model->products;
            },
            'created_at',
            'paid'
        ];
    }
}
