<?php

namespace api\modules\v1\controllers;

use api\controllers\ApiController;
use api\modules\v1\models\Order;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\ServerErrorHttpException;

class OrderController extends ApiController
{
    public $modelClass = Order::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['delete']);
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


    public function ___actionView($id)
    {
        $query = Order::findOne($id);

        return $query;
    }

    public function actionDelete($id)
    {
        $model = Order::findOne($id);
        $response = [];
        $response['success'] = false;
        if ($model) {
            if ($model->delete()) {
                $response['success'] = true;
                $response['message'] = 'Success order delete';
            }
        } else {
            $response['message'] = 'Not Found order';
        }
        return $response;
    }
}


