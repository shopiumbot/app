<?php

use panix\engine\widgets\Pjax;
use panix\engine\grid\GridView;

echo \panix\ext\fancybox\Fancybox::widget(['target' => '.image a']);

Pjax::begin(['dataProvider'=>$dataProvider]);
echo GridView::widget([
    'layoutPath' => '@user/views/layouts/_grid_layout',
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'showFooter' => true,

    'layoutOptions' => [
        //'title' => $this->context->pageName,
        'buttons' => [
            [
                'url' => ['create'],
                'label' => Yii::t('shop/admin', 'CREATE_MANUFACTURER'),
                'icon' => 'add'
            ]
        ]
    ],
]);

Pjax::end();

