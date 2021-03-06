<?php

namespace app\modules\shop\models;

use app\modules\user\components\ClientActiveRecord;
use panix\engine\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use Yii;
/**
 * Class ProductType
 *
 * @property integer $id
 * @property string $name
 *
 * @package app\modules\shop\models
 */
class ProductType extends ClientActiveRecord
{

    const MODULE_ID = 'shop';

    public static function getCSort()
    {
        $sort = new \yii\data\Sort([
            'attributes' => [
                'age',
                'name' => [
                    'asc' => ['name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC],
                ],
            ],
        ]);
        return $sort;
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop__product_type}}';
    }


    /*public function transactions() {
        return [
            self::SCENARIO_DEFAULT => self::OP_INSERT | self::OP_UPDATE,
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'trim'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name', 'categories_preset'], 'safe'],
        ];
    }

    public function getProductsCount()
    {
        return $this->hasOne(Product::class, ['id' => 'type_id'])->count();
    }

    public function getAttributeRelation()
    {
        return $this->hasMany(TypeAttribute::class, ['type_id' => 'id']);
    }

    public function getShopAttributes()
    {
        return $this->hasMany(Attribute::class, ['id' => 'attribute_id'])
            ->via('attributeRelation');
    }


    /**
     * Clear and set type attributes
     * @param $attributes array of attributes id. array(1,3,5)
     * @return mixed
     */
    public function useAttributes($attributes)
    {
        // Clear all relations
        TypeAttribute::deleteAll(['type_id' => $this->id]);

        if (empty($attributes))
            return false;

        foreach ($attributes as $attribute_id) {
            if ($attribute_id) {
                $record = new TypeAttribute;
                $record->type_id = $this->id;
                $record->attribute_id = $attribute_id;
                $record->save(false);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        // Clear type attribute relations
        TypeAttribute::deleteAll(['type_id' => $this->id]);
        return parent::afterDelete();
    }


}
