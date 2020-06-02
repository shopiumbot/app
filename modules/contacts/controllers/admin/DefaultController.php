<?php

namespace app\modules\contacts\controllers\admin;

use Yii;
use app\modules\contacts\models\Pages;
use app\modules\contacts\models\PagesSearch;
use panix\engine\controllers\AdminController;

/**
 * Class DefaultController
 * @package app\modules\contacts\controllers\admin
 */
class DefaultController extends AdminController
{


    public function actionIndex()
    {
        $this->pageName = Yii::t('contacts/default', 'MODULE_NAME');
        $this->breadcrumbs = [
            $this->pageName
        ];

        // $searchModel = new PagesSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            //      'dataProvider' => $dataProvider,
            //     'searchModel' => $searchModel,
        ]);
    }


}
