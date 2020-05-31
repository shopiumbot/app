<?php

namespace api\modules\v1\controllers;

use api\controllers\ApiController;
use api\modules\v1\models\Order;
use yii\data\ActiveDataProvider;
use Yii;

class OrderController extends ApiController
{
    public $modelClass = Order::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 50,
            ],
        ]);
        return $dataProvider;
    }


    public function actionView($id)
    {
        $query = Order::findOne($id);

        return $query;
    }

}


