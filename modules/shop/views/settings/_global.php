<?php
/**
 * @var \panix\engine\bootstrap\ActiveForm $form
 * @var \app\modules\shop\models\forms\SettingsForm $model
 */
?>

<?php echo $form->field($model, 'per_page')->dropDownList([5 => 5, 6 => 6, 7 => 7, 8 => 8]) ?>
<?php echo $form->field($model, 'group_attribute')->checkbox(); ?>
<?php echo $form->field($model, 'label_expire_new')->dropDownList($model::labelExpireNew(), ['prompt' => Yii::t('app/default', 'OFF')]); ?>
