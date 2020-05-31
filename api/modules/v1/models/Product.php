<?php

namespace api\modules\v1\models;

use app\modules\shop\models\Attribute;
use app\modules\shop\models\Product as BaseProduct;


class Product extends BaseProduct
{
    public function fields()
    {
        return [
            'id',
            'type' => function ($model) {
                return ['id' => $model->type_id, 'name' => $model->type->name];
            },

            'name',
            'sku',
            // 'manufacturer' => function ($model) {
            //    return ($model->manufacturer_id) ? $model->manufacturer : $model->manufacturer_id;
            // },
            /*'categories' => function ($model) {
                return [
                    'main_category' => $model->mainCategory->name,
                    'categories' => $model->categories
                ];
            },*/
            'manufacturer' => function ($model) {
                return ['id' => $model->manufacturer_id, 'name' => $model->manufacturer->name];
            },
            /*'supplier' => function ($model) {
                return ['id' => $model->supplier_id, 'name' => $model->supplier->name];
            },*/
            'price',
            'currency_id' => function ($model) {
                return ($model->currency_id) ? $model->currency_id : 'UAH';
            },
            'switch',
            'availability',
            'created_at',
            'updated_at',
            'characteristics' => function ($model) {
                $attributes = $model->getEavAttributes();

                $_list = [];

                $query = Attribute::find()
                    ->where(['IN', 'name', array_keys($attributes)])
                    ->sort()
                    ->all();

                foreach ($query as $m) {
                    $_list[] = [
                        'data' => $m,
                        'value' => $m->renderValue($attributes[$m->name])
                    ];

                }

                return $_list;
            }
        ];
    }
}
