<?php

namespace app\modules\user\controllers;

use app\modules\telegram\components\Api;
use Longman\TelegramBot\Exception\TelegramException;
use panix\engine\CMS;
use app\modules\user\models\forms\ChangePasswordForm;
use app\modules\user\models\forms\ForgotForm;
use app\modules\user\models\forms\LoginForm;
use app\modules\user\models\forms\ResendForm;
use app\modules\user\models\User;
use app\modules\user\models\UserKey;
use panix\engine\db\Connection;
use Yii;
use yii\base\UserException;
use yii\db\Exception;
use yii\helpers\FileHelper;
use yii\web\ForbiddenHttpException;
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
            'cachePath' => '@runtime/cache/' . $user->id
        ]);

//20c47911956ccc8ad0bcb00c34c01181 np
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

    public function actionSet()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        try {
            // Create Telegram API object
            $telegram = new Api(Yii::$app->user->token);

            if (!empty(\Yii::$app->modules['telegram']->userCommandsPath)) {
                if (!$commandsPath = realpath(\Yii::getAlias(\Yii::$app->modules['telegram']->userCommandsPath))) {
                    $commandsPath = realpath(\Yii::getAlias('@app') . \Yii::$app->modules['telegram']->userCommandsPath);
                }

                if (!is_dir($commandsPath)) throw new UserException('dir ' . \Yii::$app->modules['telegram']->userCommandsPath . ' not found!');
            }

            // Set webhook
            $result = $telegram->setWebHook(Yii::$app->user->webhookUrl);
            if ($result->isOk()) {
                Yii::$app->session->setFlash("success-webhook", Yii::t("user/default", 'Бот успешно подписан'));
                return $this->redirect(['/user/profile']);
            }
        } catch (TelegramException $e) {
            return $e->getMessage();
        }
        return null;
    }

    /**
     * @return null|string
     * @throws ForbiddenHttpException
     */
    public function actionUnset()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        if (\Yii::$app->user->isGuest) throw new ForbiddenHttpException();
        try {
            // Create Telegram API object
            $telegram = new Api(Yii::$app->user->token);

            // Unset webhook
            $result = $telegram->deleteWebhook();

            if ($result->isOk()) {
                Yii::$app->session->setFlash("success-webhook", Yii::t("user/default",'Бот успешно отписан'));
                return $this->redirect(['/user/profile']);
            }

        } catch (TelegramException $e) {
            return $e->getMessage();
        }
    }
}
