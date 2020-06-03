<?php

namespace api\modules\v1\models\cart;


use app\modules\cart\models\Delivery;
use app\modules\cart\models\Order as BaseOrder;
use app\modules\cart\models\Payment;
use panix\engine\CMS;


class Order extends BaseOrder
{

    public function fields()
    {
        return [
            'id',
            'status' => function ($model) {
                $status = $model->status;

                if ($status) {
                    return [
                        'id' => $status->id,
                        'name' => $status->name,
                        'color' => $status->color,
                    ];
                } else {
                    return null;
                }
            },
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
                $deliveryMethod = $model->deliveryMethod;
                if ($deliveryMethod) {
                    return [
                        'id' => $model->delivery_id,
                        'name' => $model->deliveryMethod->name,
                        'free_from' => $model->deliveryMethod->free_from,
                    ];
                } else {
                    return null;
                }
            },
            'payment' => function ($model) {
                $paymentMethod = $model->paymentMethod;
                if ($paymentMethod) {
                    return [
                        'id' => $model->payment_id,
                        'name' => $model->paymentMethod->name,
                    ];
                } else {
                    return null;
                }
            },
            'products' => function ($model) {
                return $model->products;
            },
            'created_at',
            'paid'
        ];
    }

    public function getProducts()
    {
        return $this->hasMany(OrderProduct::class, ['order_id' => 'id']);
    }


}
