<?php

namespace app\modules\shop\models;


use app\modules\user\components\ClientActiveRecord;
use app\modules\user\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use panix\engine\behaviors\nestedsets\NestedSetsBehavior;
use app\modules\shop\models\query\CategoryQuery;

/**
 * Class Category
 * @package app\modules\shop\models
 *
 * @property integer $id
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $name
 * @property string $full_path
 * @property integer $switch
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $countItems Relation of getCountItems()
 */
class Category extends ClientActiveRecord
{

    const MODULE_ID = 'shop';
    const route = '/admin/shop/category';
    const route_update = 'index';
    public $parent_id;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop__category}}';
    }

    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'trim'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $a['tree'] = [
            'class' => NestedSetsBehavior::class,
            'hasManyRoots' => false
        ];
        return ArrayHelper::merge($a, parent::behaviors());
    }

    /**
     * Relation ProductCategoryRef
     * @return int
     */
    public function getCountItems()
    {
        return $this->hasMany(ProductCategoryRef::class, ['category' => 'id'])->count();
    }

    public static function flatTree()
    {
        $result = [];
        $categories = Category::find()->orderBy(['lft' => SORT_ASC])->all();
        array_shift($categories);

        foreach ($categories as $c) {
            /**
             * @var self $c
             */
            if ($c->depth > 2) {
                $result[$c->id] = str_repeat(html_entity_decode('&mdash;'), $c->depth - 2) . ' ' . $c->name;
            } else {
                $result[$c->id] = ' ' . $c->name;
            }
        }

        return $result;
    }


    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {


        $childrens = $this->descendants()->all();
        if ($childrens) {
            foreach ($childrens as $children) {
                $children->saveNode(false);
            }
        }
        Yii::$app->cache->delete('CategoryUrlRule');
        return parent::afterSave($insert, $changedAttributes);
    }


    /**
     * @return string
     */
    public function title()
    {
        $value = $this->name;
        return $value;
    }



}
