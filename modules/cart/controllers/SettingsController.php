<?php

namespace app\modules\cart\controllers;

use app\modules\user\controllers\ClientController;
use Yii;
use panix\engine\controllers\AdminController;
use app\modules\cart\models\forms\SettingsForm;

class SettingsController extends ClientController
{

    public $icon = 'settings';

    public function actionIndex()
    {
        $this->pageName = Yii::t('app/default', 'SETTINGS');
        $this->breadcrumbs[] =
            [
                'label' => $this->module->info['label'],
                'url' => $this->module->info['url'],

            ];


        $this->breadcrumbs[] = $this->pageName;

        $model = new SettingsForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                Yii::$app->session->setFlash("success", Yii::t('app/default', 'SUCCESS_UPDATE'));
            }
            return $this->refresh();
        }
        return $this->render('index', [
            'model' => $model
        ]);
    }

}
