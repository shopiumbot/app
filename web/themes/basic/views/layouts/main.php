<?php

use panix\engine\Html;
use yii\widgets\Breadcrumbs;


\app\web\themes\basic\ThemeAsset::register($this);

/*$c = Yii::$app->settings->get('shop');


$this->registerJs("
        var price_penny = " . $c->price_penny . ";
        var price_thousand = " . $c->price_thousand . ";
        var price_decimal = " . $c->price_decimal . ";
     ", yii\web\View::POS_HEAD, 'numberformat');*/

//add
//Yii::$app->authManager->assign(Yii::$app->authManager->createRole('Manager'),2);

//remove
//Yii::$app->authManager->revoke(Yii::$app->authManager->createRole('Manager'),2);


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
<?= $this->render('partials/_header'); ?>
<main role="main" class="flex-shrink-0">



    <div class="container">
        <?php
        if (isset($this->context->breadcrumbs)) {
            echo Breadcrumbs::widget([
                'links' => $this->context->breadcrumbs,
            ]);
        }
        ?>
        <?= $content ?>

    </div>
</main>

<?= $this->render('partials/_footer'); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
