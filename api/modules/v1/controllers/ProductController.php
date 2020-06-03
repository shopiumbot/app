<?php

namespace api\modules\v1\controllers;

use api\controllers\ApiController;
use api\modules\v1\models\Product;
use panix\engine\CMS;
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

    private function guid()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function actionView($id)
    {
//echo $this->guid();
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
            $params = Yii::$app->getRequest()->getBodyParams();
            $model->load($params, '');


            $model->file = $params['images'];


            // print_r($model);die;
            if ($model->save()) {
                if (isset($params['images'])) {
                    foreach ($params['images'] as $file) {
                        $image = $model->attachImage($file);
                    }
                }
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


