<?php

use yii\helpers\Html;
use app\modules\shop\models\Category;

\app\modules\shop\bundles\admin\CategoryAsset::register($this);

?>

<div class="card">
    <div class="card-header">
        <h5><?= Html::encode($this->context->pageName) ?></h5>
    </div>
    <div class="card-body">
        <div class="form-group mt-3">
            <div class="col-12">
                <input class="form-control" placeholder="Поиск..." type="text"
                       onkeyup='$("#CategoryTree").jstree(true).search($(this).val())'/>
            </div>
        </div>
        <div class="col-12">
            <div class="alert alert-info">
                <?= Yii::t('app/admin', "USE_DND"); ?>
            </div>
        </div>
        <?php

        echo \panix\ext\jstree\JsTree::widget([
            'id' => 'CategoryTree',
            'allOpen' => true,
            'data'=>Category::find()->dataTree(),
            'core' => [
                'force_text' => true,
                'animation' => 0,
                'strings' => [
                    'Loading ...' => Yii::t('app/default', 'LOADING')
                ],
                "themes" => [
                    "stripes" => true,
                    'responsive' => true,
                    "variant" => "large"
                ],
                'check_callback' => true
            ],
            'plugins' => ['dnd', 'contextmenu', 'search'], //, 'wholerow', 'state'
            'contextmenu' => [
                'items' => new yii\web\JsExpression('function($node) {
                var tree = $("#CategoryTree").jstree(true);
                return {
                    "Switch": {
                        "icon":"icon-eye",
                        "label": "' . Yii::t('app/default', 'Скрыть показать') . '",
                        "action": function (obj) {
                        console.log($node);
                            $node = tree.get_node($node);
                            var id = parseInt($node.id.replace("node_", ""));
                            if(id !== 1){
                                categorySwitch($node);
                            }else{
                                common.notify("Access denied","error");
                            }
                        }
                    }, 
                    "Add": {
                        "icon":"icon-add",
                        "label": "' . Yii::t('app/default', 'CREATE') . '",
                        "action": function (obj) {
                            $node = tree.get_node($node);
                            var id = parseInt($node.id.replace("node_", ""));
                            window.location = "/shop/category/index?parent_id="+id;
                        }
                    }, 
                    "Edit": {
                        "icon":"icon-edit",
                        "label": "' . Yii::t('app/default', 'UPDATE') . '",
                        "action": function (obj) {
                            var id = parseInt($node.id.replace("node_", ""));
                            if(id !== 1){
                                $node = tree.get_node($node);
                                window.location = "/shop/category/index?id="+id;
                            }else{
                                common.notify("Access denied","error");
                            }
                        }
                    },  
                    "Rename": {
                        "icon":"icon-rename",
                        "label": "' . Yii::t('app/default', 'RENAME') . '",
                        "action": function (obj) {
                            $node = tree.get_node($node);
                            var id = parseInt($node.id.replace("node_", ""));
                            if(id !== 1){
                                tree.edit($node);
                            }else{
                                common.notify("Access denied","error");
                            }
              
                        }
                    },                         
                    "Remove": {
                        "icon":"icon-trashcan",
                        "label": "' . Yii::t('app/default', 'DELETE') . '",
                        "action": function (obj) {
                            $node = tree.get_node($node);
                            var id = parseInt($node.id.replace("node_", ""));
                            if(id !== 1){
                                if (confirm("' . Yii::t('app/default', 'DELETE_CONFIRM') . '\nТак же будут удалены все товары.")) {
                                    tree.delete_node($node);
                                }
                            }else{
                                common.notify("Access denied","error");
                            }
                        }
                    }
                };
      }')
            ]
        ]);
        ?>
    </div>
</div>
