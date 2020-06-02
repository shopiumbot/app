<?php

namespace app\modules\contacts\controllers;

use app\modules\contacts\models\SettingsForm;
use app\modules\user\controllers\ClientController;
use Yii;
use panix\engine\controllers\AdminController;

/**
 * Class DefaultController
 * @package app\modules\contacts\controllers\admin
 */
class DefaultController extends ClientController
{


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
                Yii::$app->session->setFlash("success", Yii::t('app/default', 'SUCCESS_UPDATE'));
            }
            return $this->refresh();
        }
        return $this->render('index', [
            'model' => $model
        ]);
    }


}
