<?php

namespace api\modules\v1\controllers;

use api\controllers\ApiController;
use api\modules\v1\models\shop\Product;
use app\modules\images\behaviors\ImageBehavior;
use app\modules\images\models\Image;
use app\modules\shop\models\Category;
use panix\engine\CMS;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
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
        $response = Yii::$app->getResponse();
        $result['success'] = false;
        if ($model) {
            $model->scenario = 'api_update';
            $params = Yii::$app->getRequest()->getBodyParams();
            $model->load($params, '');


            $model->file = $params['images'];


            // print_r($model);die;
            if ($model->save()) {
                if (isset($params['images'])) {
                    /** @var ImageBehavior|Product $model */
                    foreach ($params['images'] as $file) {
                        if (isset($file['url'])) {
                            $cover = (isset($file['is_main']) && $file['is_main']) ? true : false;

                            try {
                                $image = $model->attachImage($file['url'], $cover);
                                if ($image) {
                                    $result['notes'][] = 'Success upload: ' . $file['url'];
                                } else {
                                    $result['success'] = false;
                                    $result['message'] = 'Ошибка [001]';
                                    return $result;
                                }
                            } catch (Exception $exception) {
                                $response->setStatusCode(500);
                                $result['success'] = false;
                                $result['errors'][] = ['message' => 'URL: ' . $file['url']];
                                $result['message'] = $exception->getMessage();
                                return $result;
                            }

                        }

                        if (isset($file['id']) && isset($file['action'])) {
                            if ($file['action'] == 'delete') {
                                $image = Image::findOne(['id' => $file['id'], 'product_id' => $model->getPrimaryKey()]);
                                if ($image) {
                                    $model->removeImage($image);
                                } else {
                                    $result['warning'][] = 'Not found image ID: ' . $file['id'];
                                }
                            }
                        }

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
        $response = Yii::$app->getResponse();
        /* @var $model \yii\db\ActiveRecord */
        $model = new Product([
            'scenario' => 'api_create',
        ]);
        $params = Yii::$app->getRequest()->getBodyParams();
        $model->load($params, '');


        $mainCategoryId = 1;
        if (isset($params['main_category_id']))
            $mainCategoryId = $params['main_category_id'];

        $category = Category::findOne($mainCategoryId);
        if (!$category) {
            $response->setStatusCode(404);
            $result['success'] = false;
            $result['message'] = 'Not found category ID: '.$mainCategoryId;
            return $result;
        }
        if ($model->save()) {




            //if (true) { //Yii::$app->settings->get('shop', 'auto_add_subcategories')
                // Авто добавление в предков категории
                // Нужно выбирать в админки самую последнию категории по уровню.

                $categories = [];
                if ($category) {
                    $tes = $category->ancestors()->excludeRoot()->all();
                    foreach ($tes as $cat) {
                        $categories[] = $cat->id;
                    }

                }else {

                }
                $categories = ArrayHelper::merge($categories,[]);
            //} else {

               // $categories = Yii::$app->request->post('categories', []);
           // }

            $model->setCategories($categories, $mainCategoryId);

            /** @var ImageBehavior|Product $model */
            foreach ($params['images'] as $file) {
                if (isset($file['url'])) {
                    $cover = (isset($file['is_main']) && $file['is_main']) ? true : false;

                    try {
                        $image = $model->attachImage($file['url'], $cover);
                        if ($image) {
                            $result['notes'][] = 'Success upload: ' . $file['url'];
                        } else {
                            $result['success'] = false;
                            $result['message'] = 'Ошибка [001]';
                            return $result;
                        }
                    } catch (Exception $exception) {
                        $response->setStatusCode(500);
                        $result['success'] = false;
                        $result['errors'][] = ['message' => 'URL: ' . $file['url']];
                        $result['message'] = $exception->getMessage();
                        return $result;
                    }

                }
            }

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


