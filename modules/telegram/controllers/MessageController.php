<?php

namespace app\modules\telegram\controllers;

use Yii;
use app\modules\telegram\models\Message;
use app\modules\user\controllers\ClientController;
use app\modules\telegram\models\search\MessageSearch;
use app\modules\telegram\components\Api;

class MessageController extends ClientController
{

    public $icon = 'settings';

    public $layout = '@user/views/layouts/dashboard_fluid';

    public function actionIndex()
    {
        $api = new Api(Yii::$app->user->token);
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

    public function actionLoadChat(){
        $api = new Api(Yii::$app->user->token);
        $user_id = Yii::$app->request->get('user_id');
        $model = Message::find()->where(['chat_id'=>$user_id])->limit(50)->all();
        //print_r($id);die;
       // return $id;
        return $this->renderAjax('load-chat',['model'=>$model]);
    }

}
