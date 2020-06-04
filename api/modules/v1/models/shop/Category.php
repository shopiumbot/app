<?php

namespace api\modules\v1\models\shop;


use Yii;
use app\modules\shop\models\Category as BaseCategory;


class Category extends BaseCategory
{
    public function fields()
    {
        $data = [];
        return [
            'id',
            'name',
            'created_at',
            'updated_at',
            'switch'
        ];
    }

}
