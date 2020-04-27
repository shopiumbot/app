<?php

namespace app\modules\user\controllers;

use panix\engine\CMS;
use app\modules\user\models\forms\ChangePasswordForm;
use app\modules\user\models\forms\ForgotForm;
use app\modules\user\models\forms\LoginForm;
use app\modules\user\models\forms\ResendForm;
use app\modules\user\models\User;
use app\modules\user\models\UserKey;
use panix\engine\db\Connection;
use Yii;
use yii\db\Exception;
use yii\helpers\FileHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Default controller for User module
 */
class ProfileController extends ClientController
{


    /**
     * Profile
     */
    public function actionIndex()
    {

        /** @var User $user */
        $user = Yii::$app->user->identity;
        if (!$user)
            $this->error404();


        $container = new \yii\di\Container;
        $container->set('cache', [
            'class' => 'yii\caching\FileCache',
            'directoryLevel' => 0,
            'keyPrefix' => '',
            'cachePath' => '@runtime/cache/' . $user->webhook
        ]);


        $user->setScenario('profile');

        $this->pageName = Yii::t('user/default', 'PROFILE');
        $this->view->title = $this->pageName;
        $this->breadcrumbs[] = $this->pageName;

        //$user = Yii::$app->getModule("user")->model("User");

        $loadedPost = $user->load(Yii::$app->request->post());


        // validate for normal request
        if ($loadedPost && $user->validate()) {
            $user->save(false);
            Yii::$app->session->setFlash("success", Yii::t("user/default", "Profile updated"));
            return $this->refresh();
        }


        $changePasswordForm = new ChangePasswordForm();
        if ($changePasswordForm->load(Yii::$app->request->post()) && $changePasswordForm->validate()) {
            //$changePasswordForm->getUser()->setScenario("reset");
            $changePasswordForm->getUser()->save(false);
            Yii::$app->session->setFlash("change-password-success", Yii::t("user/default", "Profile updated"));
            return $this->refresh();
        }

        // validate for ajax request
        if ($loadedPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user, $changePasswordForm);
        }
        // validate for ajax request
        //if ($changePasswordForm->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
        //    Yii::$app->response->format = Response::FORMAT_JSON;
        //    return ActiveForm::validate($changePasswordForm);
        //}

        // render
        return $this->render("index", [
            'model' => $user,
            'changePasswordForm' => $changePasswordForm
        ]);
    }

}
