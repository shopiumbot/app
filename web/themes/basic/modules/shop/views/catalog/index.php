<?php
use yii\helpers\Url;
use app\modules\shop\widgets\categories\CategoriesWidget;
Url::remember(); // сохраняем URL для последующего использования

?>

<div class="container">
    <?= CategoriesWidget::widget([]) ?>
</div>
