<?php

namespace api\modules\v1\controllers;

use api\controllers\ApiController;
use api\modules\v1\models\Product;
use yii\data\ActiveDataProvider;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

class ProductController extends ApiController
{
    public $modelClass = Product::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['view'], $actions['update'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $query = Product::find();
        if (Yii::$app->request->get('manufacturer_id')) {
            $query->applyManufacturers((int)Yii::$app->request->get('manufacturer_id'));
        }
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
        $model = Product::findOne($id);
        $result['success'] = false;
        if ($model) {
            $result['item'] = $model;
            $result['success'] = true;
        } else {
            $result['message'] = 'Object not found';
        }
        return $result;
    }

    public function actionUpdate($id)
    {
        /* @var $model ActiveRecord */
        $model = Product::findOne($id);

        $result['success'] = false;
        if ($model) {
            $model->scenario = 'api_update';
            $model->load(Yii::$app->getRequest()->getBodyParams(), '');
            if ($model->save()) {
                $result['success'] = true;
                $result['message'] = Yii::t('app/default', 'SUCCESS_UPDATE');
                $result['item'] = $model;
                return $result;
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
        } else {
            $result['message'] = 'Object not found';
        }
        if ($model->hasErrors()) {
            $result['message'] = 'Error';
            $result['errors'] = $model->getErrors();
        }
        return $result;
    }

    public function actionCreate()
    {

        /* @var $model \yii\db\ActiveRecord */
        $model = new Product([
            'scenario' => 'api_create',
        ]);

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);

            $result['success'] = true;
            $result['message'] = Yii::t('app/default', 'SUCCESS_CREATE');
            $result['item'] = $model;

            return $result;
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }


    public function actionDelete($id)
    {
        $model = Product::findOne($id);

        $result['success'] = false;
        if ($model) {
            if ($model->delete()) {
                $result['success'] = true;
                $result['message'] = Yii::t('app/default', 'SUCCESS_RECORD_DELETE');
            } else {
                $result['message'] = 'Failed to delete the object for unknown reason.';
            }
        } else {
            $result['message'] = 'Object not found';
        }

        return $result;
    }
}


