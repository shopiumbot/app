<?php

use yii\helpers\Html;
use panix\engine\grid\GridView;
use panix\engine\CMS;
use app\modules\user\models\Role;
use app\modules\user\models\User;
use panix\engine\widgets\Pjax;

$user = new User;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\user\models\search\UserSearch $searchModel
 * @var app\modules\user\models\User $user
 */
$this->title = Yii::t('user/default', 'Users');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <?php Pjax::begin(['dataProvider' => $dataProvider]); ?>
    <?=
    // yii\grid\GridView
    GridView::widget([
        'tableOptions' => ['class' => 'table table-striped'],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layoutOptions' => [
            'title' => $this->context->pageName
        ],

        'columns' => [
            [
                // 'attribute' => 'role_id',
                'label' => Yii::t('user/default', 'ONLINE'),
                'format' => 'html',
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model, $index, $dataColumn) {

                    if (isset($model->session)) {
                        $content = Yii::t('user/default', 'ONLINE');
                        $options = ['class' => 'badge badge-success', 'title' => CMS::time_passed(strtotime($model->session->created_at))];
                    } else {
                        $content = Yii::t('user/default', 'OFFLINE');
                        $options = ['class' => 'badge badge-secondary'];
                    }

                    return Html::tag('span', $content, $options);
                }
            ],
            [
                'attribute' => 'status',
                'filter' => $user::statusDropdown(),
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model, $index, $dataColumn) use ($user) {
                    $statusDropdown = $user::statusDropdown();
                    if ($model->status == 1) {
                        $options['class'] = 'badge badge-success';
                    } elseif ($model->status == 2) {
                        $options['class'] = 'badge badge-secondary';
                    } else {
                        $options['class'] = 'badge badge-warning';
                    }
                    return Html::tag('span', $statusDropdown[$model->status], $options);
                }
            ],
            [
                'attribute' => 'email',
                'format' => 'email',
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'created_at',
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model, $index, $dataColumn) {
                    return CMS::date($model->created_at);
                },
            ],

            // 'new_email:email',
            // 'username',
            // 'password',
            // 'auth_key',
            // 'api_key',
            // 'login_ip',
            // 'login_time',
            // 'create_ip',
            // 'create_time',
            // 'update_time',
            // 'ban_time',
            // 'ban_reason',

            ['class' => 'panix\engine\grid\columns\ActionColumn']
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
