<?php

use yii\helpers\Html;
use panix\engine\bootstrap\ActiveForm;
use panix\engine\helpers\TimeZoneHelper;
/**
 * @var yii\web\View $this
 * @var app\modules\user\models\User $model
 * @var yii\widgets\ActiveForm $form
 */
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
?>
<?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'full_name')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'status')->dropDownList($model::statusDropdown()); ?>
<?= $form->field($model, 'image', [
    'parts' => [
        '{buttons}' => $model->getFileHtmlButton('image')
    ],
    'template' => '<div class="col-sm-4 col-lg-2">{label}</div>{beginWrapper}{input}{buttons}{hint}{error}{endWrapper}'
])->fileInput() ?>
<?= $form->field($model, 'role')->dropDownList($model->getRoles(), ['multiple' => true]); ?>
<?= $form->field($model, 'phone')->widget(\panix\ext\telinput\PhoneInput::class); ?>
<?= $form->field($model, 'subscribe')->checkbox(); ?>
<?= $form->field($model, 'gender')->dropDownList([0 => $model::t('FEMALE'), 1 => $model::t('MALE')], ['prompt' => 'Не указано']); ?>
<?= $form->field($model, 'timezone')->dropDownList(TimeZoneHelper::getTimeZoneData(), ['prompt' => 'Не указано']); ?>

<?= $form->field($model, 'ban_time')->widget(\panix\engine\jui\DatetimePicker::class, [
    'clientOptions' => [
        'minDate' => new \yii\web\JsExpression('new Date(' . date('Y') . ', ' . (date('n') - 1) . ', ' . date('d') . ')')
    ]
]) ?>
<?= $form->field($model, 'ban_reason')->textarea() ?>

<div class="card-footer text-center">
    <?= $model->submitButton(); ?>
</div>
<?php ActiveForm::end(); ?>
