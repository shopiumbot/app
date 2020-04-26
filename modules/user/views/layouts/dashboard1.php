<?php

use panix\engine\Html;
use yii\widgets\Breadcrumbs;


\app\web\themes\basic\ThemeAsset::register($this);

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



привет

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                <nav class="nav flex-column">
                    <a class="nav-link active" href="/">Active</a>
                    <a class="nav-link" href="#">Link</a>
                    <a class="nav-link" href="#">Link</a>
                </nav>

            </div>
            <div class="col-sm-9">
                <?php
                if (isset($this->context->breadcrumbs)) {
                    echo Breadcrumbs::widget([
                        'links' => $this->context->breadcrumbs,
                    ]);
                }
                ?>
                <?= $content ?>
            </div>
        </div>



    </div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
