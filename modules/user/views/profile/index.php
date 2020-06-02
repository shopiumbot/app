<?php

use yii\helpers\Html;
use app\modules\telegram\components\Api;
use panix\engine\bootstrap\ActiveForm;
use Longman\TelegramBot\Request;
/**
 * @var \yii\web\View $this
 * @var \app\modules\user\models\User $model
 * @var \app\modules\user\models\forms\ChangePasswordForm $changePasswordForm
 */



try {
    $telegram = new Api($model->token);



    $chats = \app\modules\telegram\models\Chat::find()->asArray()->all();
    if($chats){
    foreach ($chats as $chat){
        /*$send = Request::sendMessage([
            'chat_id'=>$chat['id'],
            'text'=>'test'
        ]);*/
    }

        $profile = Request::getUserProfilePhotos(['user_id'=>'1268221529']); //812367093 me
        $photo = $profile->getResult()->photos[0][2];
        $file = Request::getFile(['file_id'=>$photo['file_id']]);
        if(!file_exists(Yii::getAlias('@app/web/downloads/telegram').DIRECTORY_SEPARATOR.$file->getResult()->file_path)){
            $download = Request::downloadFile($file->getResult());
            //\panix\engine\CMS::dump($download);
        }else{
            echo Html::img('/downloads/telegram/'.$file->getResult()->file_path,['class'=>'','width'=>100]);
        }


        $member = Request::getChatMember(['chat_id'=>'812367093','user_id'=>'812367093']);
    \panix\engine\CMS::dump($member);
    }
    $me = Request::getMe();

    if ($me->isOk()) {
        $result = $me->getResult();

        ?>
        <div class="alert alert-success">Подключен
            бот: <?= Html::a($result->first_name, 'tg://@' . $result->username); ?></div>
    <?php } else { ?>
        <div class="alert alert-danger">Бот не подключен!</div>
    <?php } ?>
<?php } catch (\yii\base\Exception $e) { ?>
    <div class="alert alert-danger">Бот не подключен!</div>
<?php } ?>
<?php if (!$model->status) { ?>
    <div class="alert alert-warning">
        <?= Yii::t('user/default', 'NO_ACTIVE_ACCOUNT', [
            'email' => $model->email,
            'send' => Html::a('Отправить повторно', ['/user/resend', 'email' => $model->email], ['class' => 'btn btn-sm btn-secondary'])
        ]); ?>
    </div>
<?php } ?>
<a href="/user/profile/set">set</a>
<a href="/user/profile/unset">unset</a>

<div class="row">
    <div class="col-sm-7">
        <?php $form = ActiveForm::begin([
            'id' => 'profile-form',
            'fieldConfig' => [
                //'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
                // 'labelOptions' => ['class' => 'col-lg-22 control-label'],
            ],
            'enableAjaxValidation' => true,
        ]); ?>
        <div class="card">
            <div class="card-header">
                <?= Html::encode($this->context->pageName) ?>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-sm-4 col-lg-2"><label>API ключ</label></div>
                    <div class="col-sm-8 col-lg-10">
                        <?= $model->api_key; ?>
                    </div>
                </div>
                <?= $form->field($model, 'token'); ?>
                <?= $form->field($model, 'phone')->widget(\panix\ext\telinput\PhoneInput::class); ?>
                <?= $form->field($model, 'gender')->dropDownList($model->getGenderList(), ['prompt' => $model::t('NO_SELECT_GENDER')]); ?>
            </div>
            <div class="card-footer text-center">
                <?= Html::submitButton(Yii::t('app/default', 'UPDATE'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-sm-5">
        <?php $form = ActiveForm::begin([
            'id' => 'reset-form',
            'fieldConfig' => [
                'template' => "<div class=\"col-sm-6 col-lg-6\">{label}</div>\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                'horizontalCssClasses' => [
                    'label' => 'col-form-label',
                    'offset' => 'offset-sm-6 offset-lg-6',
                    'wrapper' => 'col-sm-6 col-lg-6',
                    'error' => '',
                    'hint' => '',
                ],
                // 'labelOptions' => ['class' => 'col-lg-22 control-label'],
            ],
        ]); ?>

        <div class="card">
            <div class="card-header">
                <?= Yii::t('user/default', 'CHANGE_PASSWORD'); ?>
            </div>
            <div class="card-body">
                <?php if ($flash = Yii::$app->session->getFlash("change-password-success")) { ?>
                    <div class="alert alert-success">
                        <?= $flash ?>
                    </div>
                <?php } ?>
                <?= $form->field($changePasswordForm, 'current_password')->passwordInput() ?>
                <?= $form->field($changePasswordForm, 'new_password')->passwordInput() ?>
                <?= $form->field($changePasswordForm, 'new_repeat_password')->passwordInput() ?>

            </div>
            <div class="card-footer text-center">
                <?= Html::submitButton(Yii::t('app/default', 'UPDATE'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>


