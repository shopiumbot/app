<?php

namespace app\modules\contacts\controllers;

use Yii;
use panix\engine\controllers\WebController;
use app\modules\contacts\models\ContactForm;


class DefaultController extends WebController
{

    public function actionIndex()
    {
        $this->pageName = Yii::t('contacts/default', 'MODULE_NAME');
        $this->view->title = $this->pageName;
        $this->breadcrumbs = [
            $this->pageName
        ];
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $emails = explode(',',Yii::$app->settings->get('contacts', 'email'));
                foreach ($emails as $email){
                    $model->send($email);
                }

                Yii::$app->session->setFlash('success', Yii::t('contacts/default', 'SUCCESS_SEND_FORM'));

                return $this->refresh();
            }
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

}
