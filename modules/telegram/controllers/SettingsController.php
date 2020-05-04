<?php

namespace app\modules\telegram\controllers;

use app\modules\user\controllers\ClientController;
use Yii;
use app\modules\telegram\models\SettingsForm;

class SettingsController extends ClientController
{

    public $icon = 'settings';

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

        $model = new SettingsForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
            }

        }
        return $this->render('index', [
            'model' => $model
        ]);
    }

}
