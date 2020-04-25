<?php

namespace app\modules\user\controllers;

use panix\engine\CMS;
use panix\engine\controllers\WebController;
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
class DefaultController extends WebController
{

    /**
     * @inheritdoc
     */
    /*public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'allowActions' => [
                    '*',
                    // The actions listed here will be allowed to everyone including guests.
                ]
            ],
        ];
    }*/

    /**
     * Display index - debug page, login page, or account page
     *
     * @return string|Response
     */
    public function actionIndex()
    {
        if (defined('YII_DEBUG') && YII_DEBUG) {
            $actions = Yii::$app->getModule("user")->getActions();
            return $this->render('index', ["actions" => $actions]);
        } elseif (Yii::$app->user->isGuest) {
            return $this->redirect(["/user/login"]);
        } else {
            return $this->redirect(["/user/account"]);
        }
    }

    /**
     * Display login page
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        $config = Yii::$app->settings->get('user');
        if (Yii::$app->user->isGuest) {
            $this->pageName = Yii::t('user/default', 'LOGIN');
            $this->breadcrumbs = [
                $this->pageName
            ];

            // load post data and login
            $model = new LoginForm();

            if ($model->load(Yii::$app->request->post()) && $model->login($config->login_duration * 86400)) {
                return $this->goBack(Yii::$app->getModule("user")->loginRedirect);
            }

            // render
            return $this->render('login', [
                'model' => $model,
            ]);
        } else {
            return $this->redirect(['/']);
        }
    }

    /**
     * Log user out and redirect
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        // redirect
        $logoutRedirect = Yii::$app->getModule("user")->logoutRedirect;
        if ($logoutRedirect === null) {
            return $this->goHome();
        } else {
            return $this->redirect($logoutRedirect);
        }
    }

    /**
     * Display registration page
     *
     * @return array|string|Response
     */
    public function actionRegister()
    {
        $config = Yii::$app->settings->get('user');
        if ($config->enable_register) {
            // set up new user/profile objects
            $user = new User(["scenario" => "register"]);
            $this->pageName = Yii::t('user/default', 'REGISTER');
            $this->breadcrumbs[] = $this->pageName;
            // load post data
            $post = Yii::$app->request->post();


            /*$mailer = Yii::$app->mailer;
            $subject = Yii::t("user/default", "👍 😀 ⚠  🛒  🔑 🔔 🏆 🎁 🎉 🤝 👉 Email Confirmation");
            $message = $mailer->compose(['html'=>'admin.tpl'], ['test'=>'dsa'])
                ->setTo('dev@pixelion.com.ua')
                ->setSubject($subject);
            $message->send();*/

            $user->role = 'user';
            if ($user->load($post)) {

                $user->username = $user->email;
                // validate for ajax request
                if (Yii::$app->request->isAjax) {
                    // Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($user);
                }

                //print_r($user->attributes);die;
                // validate for normal request
                if ($user->validate()) {

                    // perform registration
                    $user->setRegisterAttributes(Yii::$app->request->userIP)->save(false);
                    $this->afterRegister($user);

                    // set flash
                    // don't use $this->refresh() because user may automatically be logged in and get 403 forbidden
                    $successText = Yii::t("user/default", "REGISTER_SUCCESS", ["username" => $user->getDisplayName()]);
                    Yii::$app->session->setFlash("success", $successText);
                }
            }

            // render
            return $this->render("register", [
                'user' => $user,
            ]);
        } else {
            return $this->redirect(['/']);
        }

    }

    /**
     * Process data after registration
     *
     * @param \app\modules\user\models\User $user
     */
    protected function afterRegister($user)
    {
        // determine userKey type to see if we need to send email
        $userKey = new UserKey;
        $config = Yii::$app->settings->get('user');
        if ($user->status == $user::STATUS_INACTIVE) {
            $userKeyType = $userKey::TYPE_EMAIL_ACTIVATE;
        } elseif ($user->status == $user::STATUS_UNCONFIRMED_EMAIL) {
            $userKeyType = $userKey::TYPE_EMAIL_CHANGE;
        } else {
            $userKeyType = null;
        }

        // check if we have a userKey type to process, or just log user in directly
        if ($userKeyType) {
            $this->registerInHosting($user);

            // generate userKey and send email
            $userKey = $userKey::generate($user->id, $userKeyType);
            if (!$numSent = $user->sendEmailConfirmation($userKey)) {

                // handle email error
                //Yii::$app->session->setFlash("Email-error", "Failed to send email");


            }
        } else {
            Yii::$app->user->login($user, $config->login_duration * 86400);
        }
    }

    private function unZip($user)
    {
        $file = Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'client.zip';
        if (file_exists($file)) {
            $zipFile = new \PhpZip\ZipFile();
            $zipFile->openFile($file);
            $subDomainPath = Yii::getAlias('@app') . '/../' . $user->domain;
            FileHelper::createDirectory($subDomainPath, $mode = 0750, $recursive = true);
            $extract = $zipFile->extractTo($subDomainPath);
            Yii::debug('Extract files ', 'Hosting/Api');

            if ($extract) {
                $replacements = require($subDomainPath . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . '_db.php');
                $configDb = array_replace($replacements, [
                    'dsn' => 'mysql:host=corner.mysql.tools;dbname=' . $user->db_name,
                    'username' => $user->db_user,
                    'password' => $user->db_password,
                    'tablePrefix' => CMS::gen(4) . '_',
                ]);
                $filePath = $subDomainPath . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . '_db.php';

                if (!@file_put_contents($filePath, '<?php return ' . var_export($configDb, true) . ';')) {
                    throw new \yii\base\Exception(Yii::t('app/default', 'Error write modules setting in {file}...', ['file' => $filePath]));
                }
                $runMigrate = shell_exec('/usr/local/php73/bin/php -f /home/corner/shopiumbot.com/'.$user->domain.'/cmd migrate --interactive=0');
            }
        } else {
            die('no find file zip');
        }
    }

    /**
     * Process data after registration
     *
     * @param \app\modules\user\models\User $user
     */
    public function registerInHosting($user)
    {
        $user = User::findOne($user->id);

        $user->setScenario('db');


        $data = [
            'class' => 'hosting_site',
            'method' => 'host_create',
            'site' => Yii::$app->request->serverName,
            'subdomain' => 'bot' . $user->id,
        ];
        $createDomain = Yii::$app->getModule('user')->hostingApi($data);
        if ($createDomain['status'] == 'success') {
            $user->domain = $data['subdomain'];


            $dataDb = [
                'class' => 'hosting_database',
                'method' => 'database_create',
                'name' => 'bot' . $user->id,
                'collation' => 'utf8_general_ci',
                'user_create' => true,
            ];
            $createDb = Yii::$app->getModule('user')->hostingApi($dataDb);
            if ($createDb['status'] == 'success') {
                if ($createDb['data']['user']['status'] == 'success') {

                    $user->db_name = $createDb['data']['user']['login'];
                    $user->db_password = $createDb['data']['user']['password'];
                    $user->db_user = $createDb['data']['user']['login'];
                    $this->unZip($user);
                }
            } else {
                echo print_r($createDb['message']);
            }

            $ssldata = [
                'class' => 'hosting_site_config_ssl',
                'method' => 'crt_lets_encrypt',
                'host' => $data['subdomain'] . '.' . $data['site'],

            ];
            $setSSL = Yii::$app->getModule('user')->hostingApi($ssldata);
            if ($setSSL['status'] == 'success') {
                //  CMS::dump($setSSL);
            }


            $phpdata = [
                'class' => 'hosting_site_config_php',
                'method' => 'edit',
                'host' => $data['subdomain'] . '.' . $data['site'],
                'php_version' => 'php73',
                'php_short_open_tag'=>true,
                'php_open_basedir'=>'none',
                'display_errors'=>true,
                'php_error_reporting'=>[
                    [
                        "E_ERROR",
                        "E_PARSE",
                        "E_CORE_ERROR",
                        "E_COMPILE_ERROR"
                    ]
                ],
                'post_max_size'=>50,
                'max_input_time'=>60,
                'php_max_input_vars'=>1000,
                'php_max_execution_time_user'=>30,
                'php_output_buffering'=>true

            ];
            $editPHP = Yii::$app->getModule('user')->hostingApi($phpdata);
            if ($editPHP['status'] == 'success') {
                //  CMS::dump($editPHP);
            }

            $config_ws = [
                'class' => 'hosting_site_config_ws',
                'method' => 'edit',
                'host' => $data['subdomain'] . '.' . $data['site'],
                'https_redirect' => 'to_https',
                'redirect' => 'www_from',
                'disable_service_url'=>true,
                'static_404_redirect'=>true,
                'modsecurity_enabled'=>true,
                //'aliases'=>'www.'.$data['subdomain'] . '.' . $data['site'],
                'static_files'=>'avi,bmp,png,css,doc,gif,htm,html,ico,jpeg,jpg,js,mp3,swf,txt,xls,zip,wml,wmlc,wmls,wmlsc,wbmp,fla,flv,mpg,mpeg,pdf,woff,eot,otf,svg,ttf,woff2,docx,xlsx,ppt,pptx,webp,mp4'

            ];
            $response_config_ws = Yii::$app->getModule('user')->hostingApi($config_ws);
            if ($response_config_ws['status'] == 'success') {
                //  CMS::dump($response_config_ws);
            }

           // $this->setAttributes($attributes, false);
            // print_r($createDomain);

           // CMS::dump($user);die;
            $user->save(false);
        } else {
            echo print_r($createDomain['message']);
        }


    }

    /**
     * Confirm email
     */
    public function actionConfirm($key)
    {
        /** @var \app\modules\user\models\UserKey $userKey */
        /** @var \app\modules\user\models\User $user */
        // search for userKey
        $success = false;
        $userKey = new UserKey;

        $userKey = $userKey::findActiveByKey($key, [$userKey::TYPE_EMAIL_ACTIVATE, $userKey::TYPE_EMAIL_CHANGE]);

        if ($userKey) {

            // confirm user
            $user = new User;
            $user = $user::findOne($userKey->user_id);
            $user->confirm();

            // consume userKey and set success
            $userKey->consume();
            $success = $user->email;
        }

        $this->pageName = Yii::t('user/default', $success ? 'CONFIRMED' : 'ERROR');
        $this->breadcrumbs[] = $this->pageName;

        // render
        return $this->render("confirm", [
            "userKey" => $userKey,
            "success" => $success
        ]);
    }

    /**
     * Account
     */
    public function actionAccount()
    {
        $user = Yii::$app->user->identity;
        $user->setScenario("account");
        $loadedPost = $user->load(Yii::$app->request->post());

        // validate for ajax request
        if ($loadedPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user);
        }

        // validate for normal request
        if ($loadedPost && $user->validate()) {

            // generate userKey and send email if user changed his email
            if (Yii::$app->getModule("user")->emailChangeConfirmation && $user->checkAndPrepEmailChange()) {

                $userKey = Yii::$app->getModule("user")->model("UserKey");
                $userKey = $userKey::generate($user->id, $userKey::TYPE_EMAIL_CHANGE);
                if (!$numSent = $user->sendEmailConfirmation($userKey)) {

                    // handle email error
                    //Yii::$app->session->setFlash("Email-error", "Failed to send email");
                }
            }

            // save, set flash, and refresh page
            $user->save(false);
            Yii::$app->session->setFlash("Account-success", Yii::t("user/default", "Account updated"));
            return $this->refresh();
        }

        // render
        return $this->render("account", [
            'user' => $user,
        ]);
    }

    /**
     * Profile
     */
    public function actionProfile()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        if (!$user)
            $this->error404();

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
        return $this->render("profile", [
            'model' => $user,
            'changePasswordForm' => $changePasswordForm
        ]);
    }

    /**
     * Resend email confirmation
     */
    public function actionResend()
    {
        $this->pageName = Yii::t('user/default', 'RESEND');
        // $this->breadcrumbs[] =  $this->pageName;
        /** @var ResendForm $model */
        $model = Yii::$app->getModule("user")->model("ResendForm");

        $data = (Yii::$app->user->isGuest) ? Yii::$app->request->post() : ['ResendForm' => Yii::$app->request->get()];
        if ($model->load($data) && $model->sendEmail()) {
            Yii::$app->session->setFlash("resend-success", Yii::t("user/default", "CONFIRM_EMAIL_RESENT"));
        }

        return $this->render("resend", [
            "model" => $model,
        ]);
    }

    /**
     * Resend email change confirmation
     */
    public function actionResendChange()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        $userKey = new UserKey;
        $userKey = $userKey::findActiveByUser($user->id, UserKey::TYPE_EMAIL_CHANGE);
        if ($userKey) {

            // send email and set flash message
            $user->sendEmailConfirmation($userKey);
            Yii::$app->session->setFlash("resend-success", Yii::t("user/default", "Confirmation email resent"));
        }

        return $this->redirect(["/user/account"]);
    }

    /**
     * Cancel email change
     */
    public function actionCancel()
    {
        $user = Yii::$app->user->identity;
        $userKey = new UserKey;
        $userKey = $userKey::findActiveByUser($user->id, $userKey::TYPE_EMAIL_CHANGE);
        if ($userKey) {

            // remove `user.new_email`
            $user->new_email = null;
            $user->save(false);

            // expire userKey and set flash message
            $userKey->expire();
            Yii::$app->session->setFlash("Cancel-success", Yii::t("user/default", "Email change cancelled"));
        }

        return $this->redirect(["/user/account"]);
    }

    /**
     * Forgot password
     * @return string
     */
    public function actionForgot()
    {
        $config = Yii::$app->settings->get('user');
        // if ($config->enable_forgot) {
        $model = new ForgotForm();
        $this->pageName = Yii::t('user/default', 'FORGOT');
        if ($model->load(Yii::$app->request->post()) && $model->sendForgotEmail()) {

            // set flash (which will show on the current page)
            Yii::$app->session->setFlash("forgot-success", Yii::t("user/default", "FORGOT_SEND_SUCCESS"));
        }

        return $this->render("forgot", [
            "model" => $model,
        ]);
        // } else {
        //     return $this->redirect(['/']);
        // }
    }

    /**
     * Reset password
     *
     * @param $key
     * @return string
     */
    public function actionReset($key)
    {


        $this->pageName = Yii::t('user/default', 'RESET_PASSWORD');
        $this->breadcrumbs[] = $this->pageName;

        /** @var UserKey $userKey */
        $userKey = UserKey::findActiveByKey($key, UserKey::TYPE_PASSWORD_RESET);
        if (!$userKey) {
            return $this->render('reset', ["invalidKey" => true]);
        }

        // get user and set "reset" scenario
        $success = false;
        $user = User::findOne($userKey->user_id);
        $user->setScenario("reset");

        // load post data and reset user password
        if ($user->load(Yii::$app->request->post()) && $user->save()) {

            // consume userKey and set success = true
            $userKey->consume();
            $success = true;
        }

        return $this->render('reset', compact("user", "success"));
    }

}
