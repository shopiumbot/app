<?php

use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var \app\modules\user\models\User $model
 * @var \app\modules\user\models\forms\ChangePasswordForm $changePasswordForm
 */


print_r(Yii::$app->user->clientDb);

?>
<?php if(!$model->status){ ?>
<div class="alert alert-warning">
    <?= Yii::t('user/default','NO_ACTIVE_ACCOUNT',[
            'email'=>$model->email,
        'send'=>Html::a('Отправить повторно',['/user/resend','email'=>$model->email],['class'=>'btn btn-sm btn-secondary'])
    ]);?>
</div>
<?php } ?>
<?php
echo $this->render('_tabs', ['model'=>$model,'changePasswordForm'=>$changePasswordForm]);
?>

<div class="button spin circle">Spin Circle</div>
