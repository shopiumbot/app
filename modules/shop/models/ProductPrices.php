<?php

namespace app\modules\shop\models;

use app\modules\user\components\ClientActiveRecord;
use Yii;
use app\modules\shop\models\query\ProductQuery;
use yii\db\ActiveRecord;

/**
 * Class ProductPrices
 *
 * @property integer $id
 * @property integer $from
 * @property string $value
 * @property integer $product_id
 *
 * @package app\modules\shop\models
 */
class ProductPrices extends ClientActiveRecord
{

    const route = '/admin/shop/default';
    const MODULE_ID = 'shop';

    public static function find2()
    {
        return new ProductQuery(get_called_class());
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop__product_prices}}';
    }

    /**
     * Replaces comma to dot
     * @param $attr
     */
    public function commaToDot($attr)
    {
        $this->$attr = str_replace(',', '.', $this->$attr);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['value', 'commaToDot'],
            [['from', 'value'], 'required'],
            [['from'], 'integer'],
            [['value'], 'safe'],
        ];
    }


}
