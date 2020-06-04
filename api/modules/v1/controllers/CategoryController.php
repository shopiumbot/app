<?php

namespace api\modules\v1\controllers;

use api\controllers\ApiController;
use api\modules\v1\models\shop\Category;
use panix\engine\CMS;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use Yii;
use yii\web\ServerErrorHttpException;

class CategoryController extends ApiController
{
    public $modelClass = Category::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create']);
        return $actions;
    }

    public function actionIndex($tree = false)
    {


        if ($tree) {
            $items = Category::find()->tree(1);
            if ($items) {
                $data['success'] = true;
                $data['items'] = $items;
            } else {
                $data['success'] = false;
                $data['message'] = 'Error';
            }
            return $data;
        } else {
            $query = Category::find()->excludeRoot();
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'defaultPageSize' => 50,
                ],
            ]);
        }
        return $dataProvider;
    }

    public function actionCreate()
    {
        $response = Yii::$app->getResponse();
        /* @var $model \yii\db\ActiveRecord */
        $model = new Category();
        $params = Yii::$app->getRequest()->getBodyParams();
        $model->load($params, '');


        if (Yii::$app->request->get('parent')) {
            $model->parent_id = Category::findOne((int)Yii::$app->request->get('parent'));
            if (!$model->parent_id) {
                $response->setStatusCode(404);
                $data['success'] = false;
                $data['message'] = 'Not found parent category ID ' . Yii::$app->request->get('parent');
                return $data;
            }
        } else {
            $model->parent_id = Category::findOne(1);
        }


        if ($model->getIsNewRecord()) {
            if ($model->appendTo($model->parent_id)) {
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
             $result['success'] = true;
             $result['message'] = Yii::t('app/default', 'SUCCESS_CREATE');

        } else {
            if ($model->saveNode()) {
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
            $result['success'] = true;
            $result['message'] = Yii::t('app/default', 'SUCCESS_CREATE');

        }
        $response->setStatusCode(201);
        $result['item'] = $model;
        return $result;
    }

}


