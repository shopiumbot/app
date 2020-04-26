<?php

namespace app\modules\cart\models;

use app\modules\user\components\ClientActiveRecord;
use yii\db\ActiveRecord;

/**
 * Class DeliveryPayment
 *
 * @property integer $delivery_id
 * @property integer $payment_id
 *
 * @package app\modules\cart\models
 */
class DeliveryPayment extends ClientActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order__delivery_payment}}';
    }

}
