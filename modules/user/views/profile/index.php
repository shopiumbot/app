<?php

use panix\engine\Html;
use app\modules\telegram\components\Api;
use panix\engine\bootstrap\ActiveForm;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\InlineKeyboardButton;

/**
 * @var \yii\web\View $this
 * @var \app\modules\user\models\User $model
 * @var \app\modules\user\models\forms\ChangePasswordForm $changePasswordForm
 */



    $telegram = new Api($model->token);


    $chats = \app\modules\telegram\models\Chat::find()->asArray()->all();
    if ($chats) {
        foreach ($chats as $chat) {
            /*$send = Request::sendMessage([
                'chat_id'=>$chat['id'],
                'text'=>'test'
            ]);*/
        }
        /*$venue = Request::sendVenue([
            'chat_id' => $chat['id'],
            'latitude' => 46.3974947,
            'longitude' => 30.7125803,
            'title' => 'Pixelion',
            'address' => 'Pixelion address',
        ]);*/

        $keyboards[] = [
            new InlineKeyboardButton([
                'text' => 'Pay 1.00UAH',
                'callback_data' => "cartDelete"
            ]),
            new InlineKeyboardButton([
                'text' => '—',
                'callback_data' => "spinner/down/cart"
            ]),

        ];
        /*$invoice = Request::sendInvoice([
            'chat_id' => $chat['id'],
            'title' => 'title',
            'description' => 'description',
            'payload' => 'order-id',
            'provider_token' => '632593626:TEST:i56982357197',
            'start_parameter' => 'start_parameter',
            'currency' => 'UAH',
            'prices' => [
                new \Longman\TelegramBot\Entities\Payments\LabeledPrice([
                    'label' => 'test',
                    'amount' => 100
                ]),
            ],

            'disable_notification' => false,
            'reply_markup' => new \Longman\TelegramBot\Entities\InlineKeyboard([
                'inline_keyboard' => $keyboards
            ])

        ]);*/

        //\panix\engine\CMS::dump($invoice);

    }
    $me = Request::getMe();

?>

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

        <?php if(Yii::$app->session->hasFlash('success')){
            echo  Yii::$app->session->getFlash('success');
        }?>


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
                        <?= Html::a(Html::icon('s'), ['']); ?>
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
        <div class="card">
            <div class="card-header">
                <?php
                if ($me->isOk()) { ?>
                    Подключен бот: <?= Html::a($me->getResult()->first_name, 'tg://resolve?domain=' . $me->getResult()->username); ?>
                <?php }else{ ?>
                    Бот не подключен!
                <?php } ?>

            </div>
            <div class="card-body">
                <?php
                if ($me->isOk()) {
                    $result = $me->getResult();
                    $profile = Request::getUserProfilePhotos(['user_id' => $result->id]); //812367093 me

                    if($profile->getResult()->photos){
                    $photo = $profile->getResult()->photos[0][2];
                    $file = Request::getFile(['file_id' => $photo['file_id']]);
                    if (!file_exists(Yii::getAlias('@app/web/downloads/telegram') . DIRECTORY_SEPARATOR . $file->getResult()->file_path)) {
                        $download = Request::downloadFile($file->getResult());

                    } else {
                        echo Html::img('/downloads/telegram/' . $file->getResult()->file_path, ['class' => 'mb-4', 'width' => 100]);
                    }
                    }
                    ?>
                <?php } ?>

                <?php if ($model->plan_id) { ?>
                    <div class="form-group row">
                        <div class="col-sm-5 col-lg-5"><label>Текущий тариф</label></div>
                        <div class="col-sm-7 col-lg-7">
                            <div class="row">
                                <div class="col-lg-6">
                                    <?= Yii::$app->params['plan'][$model->plan_id]['name']; ?>
                                    <?php if ($model->trial) {
                                        echo Html::tag('span', 'TRIAL', ['class' => 'badge badge-danger']);
                                    }
                                    ?>
                                </div>
                                <div class="col-lg-6 text-lg-right"><?= Html::a('Оплатить','',['class'=>'btn btn-success']); ?></div>
                            </div>

                        </div>
                    </div>
                <?php } ?>
                <?php if ($model->expire) { ?>
                    <div class="form-group row">
                        <div class="col-sm-5 col-lg-5"><label>Продлен до</label></div>
                        <div class="col-sm-7 col-lg-7">
                            <?= \panix\engine\CMS::date($model->expire); ?>
                        </div>
                    </div>
                <?php } ?>

            </div>

        </div>
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


