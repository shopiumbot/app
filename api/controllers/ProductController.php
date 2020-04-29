<?php

namespace api\controllers;

use app\modules\shop\models\Product;
use yii\rest\ActiveController;


class ProductController extends ApiController
{
    public $modelClass = Product::class;
}


