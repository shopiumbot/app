<?php

namespace app\modules\telegram\controllers;

use app\modules\user\controllers\ClientController;
use app\modules\telegram\models\search\MessageSearch;
use Yii;
use panix\engine\controllers\AdminController;

class MessageController extends ClientController
{

    public $icon = 'settings';

    public $layout = '@user/views/layouts/dashboard_fluid';
    public function actionIndex()
    {
        $this->pageName = Yii::t('app/default', 'SETTINGS');
        $this->breadcrumbs = [
            [
                'label' => $this->module->info['label'],
                'url' => $this->module->info['url'],
            ],
            $this->pageName
        ];
        $searchModel = new MessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


}
