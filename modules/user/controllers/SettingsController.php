<?php

namespace app\modules\user\controllers;

use Yii;
use app\modules\user\models\forms\SettingsForm;

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
