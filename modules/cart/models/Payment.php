<?php

namespace app\modules\cart\models;

use app\modules\cart\components\payment\PaymentSystemManager;
use app\modules\user\components\ClientActiveRecord;
use panix\engine\db\ActiveRecord;

/**
 * Class Payment
 * @package app\modules\cart\models
 */
class Payment extends ClientActiveRecord
{

    const MODULE_ID = 'cart';

    public static function tableName()
    {
        return '{{%order__payment}}';
    }

    public static function find()
    {
        return new query\DeliveryPaymentQuery(get_called_class());
    }


    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'trim'],
            [['name', 'payment_system'], 'string', 'max' => 255],
            [['id', 'name', 'switch'], 'safe'],
        ];
    }

    public function getPaymentSystemsArray()
    {
        // Yii::import('application.modules.shop.components.payment.PaymentSystemManager');
        $result = array();

        $systems = new PaymentSystemManager();

        foreach ($systems->getSystems() as $system) {
            $result[(string)$system->id] = $system->name;
        }

        return $result;
    }

    /**
     * Renders form display on the order view page
     */
    public function renderPaymentForm(Order $order)
    {
        if ($this->payment_system) {
            $manager = new PaymentSystemManager;
            $system = $manager->getSystemClass($this->payment_system);
            return $system->renderPaymentForm($this, $order);
        }
    }

    /**
     * @return null|BasePaymentSystem
     */
    public function getPaymentSystemClass()
    {
        if ($this->payment_system) {
            $manager = new PaymentSystemManager;
            return $manager->getSystemClass($this->payment_system);
        }
    }

}
