<?php

use panix\engine\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var \app\modules\user\models\User $model
 * @var \app\modules\user\models\forms\ChangePasswordForm $changePasswordForm
 */
?>


<div class="row">
    <div class="col-md-6">
        <h2><?= Html::encode($this->context->pageName) ?></h2>

        <?php $form = ActiveForm::begin([
            'id' => 'profile-form',
            'fieldConfig' => [
                //'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
               // 'labelOptions' => ['class' => 'col-lg-22 control-label'],
            ],
            'enableAjaxValidation' => true,
        ]); ?>


        <?= $form->field($model, 'phone')->widget(\panix\ext\telinput\PhoneInput::class); ?>
        <?= $form->field($model, 'gender')->dropDownList($model->getGenderList(), ['prompt' => $model::t('NO_SELECT_GENDER')]); ?>
        <?= $form->field($model, 'subscribe')->checkbox(); ?>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <?= Html::submitButton(Yii::t('app/default', 'UPDATE'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-md-6">
        <h2><?= Yii::t('user/default', 'CHANGE_PASSWORD'); ?></h2>
        <?= $this->render('change-password', [
            'model' => $changePasswordForm
        ]); ?>
    </div>
</div>
