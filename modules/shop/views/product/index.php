<?php
use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;
use panix\ext\fancybox\Fancybox;
use app\modules\shop\bundles\admin\ProductIndex;

echo Fancybox::widget(['target' => '.image a']);



Pjax::begin(['dataProvider' => $dataProvider]);
ProductIndex::register($this);
echo GridView::widget([
    'layoutPath' => '@user/views/layouts/_grid_layout',
    'id' => 'grid-product',
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
   // 'enableLayout'=>false,
    'showFooter' => true,
    'layoutOptions' => [
        'title' => $this->context->pageName,
        'buttons' => [
            [
                'url' => ['create'],
                'label' => Yii::t('shop/admin', 'CREATE_PRODUCT'),
                'icon' => 'add'
            ]
        ]
    ],
    //'footerRowOptions' => ['class' => 'text-center'],
]);
Pjax::end();


