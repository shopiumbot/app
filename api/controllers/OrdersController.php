<?php

namespace api\controllers;

use app\modules\shop\models\Product;
use app\modules\cart\models\Order;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use Yii;

class OrdersController extends ApiController
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


    public function actionManufacturer()
    {
        $query = Product::find();
        if(Yii::$app->request->get('id')){
            $query->applyManufacturers((int)Yii::$app->request->get('id'));
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 50,
            ],
        ]);
        return $query->one();
    }

}


