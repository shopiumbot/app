<?php

namespace app\modules\shop\models;

use app\modules\user\components\ClientActiveRecord;
use yii\db\ActiveRecord;
use Yii;
/**
 * This is the model class for table "ProductAttributesEav".
 */
class ProductAttributesEav extends ClientActiveRecord
{

    public static function tableName()
    {
        return '{{%shop__product_attribute_eav}}';
    }

}
