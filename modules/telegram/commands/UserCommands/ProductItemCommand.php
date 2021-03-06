<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\modules\telegram\commands\UserCommands;


use app\modules\shop\models\Attribute;
use app\modules\telegram\components\InlineKeyboardPager;
use app\modules\telegram\components\KeyboardPagination;
use app\modules\telegram\components\SystemCommand;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
use Longman\TelegramBot\Entities\InputMedia\InputMediaPhoto;
use Longman\TelegramBot\Request;
use app\modules\cart\models\Order;
use app\modules\cart\models\OrderProduct;
use panix\engine\Html;
use Yii;

/**
 * User "/checkout" command TTTTTTTTTTTTTTTTTTTTTEST command
 *
 * Command that demonstrated the Conversation funtionality in form of a simple survey.
 */
class ProductItemCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'productitem';

    /**
     * @var string
     */
    protected $description = 'productitem';

    /**
     * @var string
     */
    protected $version = '1.0.0';


    /**
     * @var bool
     */
    protected $private_only = true;
    public $photo_index = 0;
    public $product;

    public function execute()
    {

        $update = $this->getUpdate();


        if (($this->photo_index = $this->getConfig('photo_index')) === '') {
            $this->photo_index = 0;
        }

        $this->product = $this->getConfig('product');
        $callbackData = false;
        if ($update->getCallbackQuery()) {
            $callbackQuery = $update->getCallbackQuery();
            $message = $callbackQuery->getMessage();
            $user = $callbackQuery->getFrom();
            parse_str($callbackQuery->getData(), $params);
            if (isset($params['command'])) {
                if ($params['command'] == 'changeProductImage') {
                    $callbackData = 'changeProductImage';
                }
            }
            if (isset($params['query'])) {
                if ($params['query'] == 'addCart') {
                    $callbackData = $params['query'];
                } elseif ($params['query'] == 'deleteInCart') {
                    $callbackData = $params['query'];
                } elseif ($params['query'] == 'productSpinner') {
                    $callbackData = $params['query'];
                }
            }

        } else {
            $message = $this->getMessage();
            $user = $message->getFrom();
        }
        $chat = $message->getChat();
        $chat_id = $chat->getId();
        $user_id = $user->getId();
        $keyboards = [];
        //$this->notify($callbackData);

        $order = Order::findOne(['user_id' => $user_id, 'checkout' => 0]);
        $product = $this->product;


        $caption = '';
        if ($product->hasDiscount) {
            $caption .= '🔥🔥🔥';
        }

        $caption .= '*' . $product->name . '*' . PHP_EOL;
        $caption .= $this->number_format($product->price) . ' грн' . PHP_EOL . PHP_EOL;

        if ($product->hasDiscount) {
            $caption .= '*🎁 Скидка*: ' . $product->discountSum . PHP_EOL . PHP_EOL;
        }

        if ($product->manufacturer_id) {
            $caption .= '*Производитель*: ' . $product->manufacturer->name . PHP_EOL;
        }
        if ($product->sku) {
            $caption .= '*Артикул*: ' . $product->sku . PHP_EOL;
        }


        $attributes = $this->attributes($product);
        if ($attributes) {
            $caption .= '*Характеристики:*' . PHP_EOL;
            foreach ($attributes as $name => $data) {
                if (!empty($data['value'])) {
                    $caption .= '*' . $name . '*: ' . $data['value'] . ' ' . $data['abbreviation'] . PHP_EOL;
                }
            }
        }
        if ($product->description) {
            $caption .= PHP_EOL . Html::encode($product->description) . PHP_EOL . PHP_EOL;
        }
        if ($order) {
            $orderProduct = OrderProduct::findOne(['product_id' => $product->id, 'order_id' => $order->id]);
        } else {
            $orderProduct = null;
        }


        //check tarif plan
        $images = $product->getImages();
        if (true) {


            $pages2 = new KeyboardPagination([
                'totalCount' => count($images),
                'defaultPageSize' => 1,
                //'pageSize'=>3
            ]);
            $pages2->setPage($this->photo_index);
            $pagerPhotos = new InlineKeyboardPager([
                'pagination' => $pages2,
                'lastPageLabel' => false,
                'firstPageLabel' => false,
                'maxButtonCount' => 1,
                'command' => 'changeProductImage&product_id=' . $product->id
                //'command' => 'getCatalogList&change=1',
                //'callback_data'=>'command={command}&photo_index={page}'
            ]);
            if ($pagerPhotos->buttons)
                $keyboards[] = $pagerPhotos->buttons;

        }


        if ($orderProduct) {
            $keyboards[] = [
                new InlineKeyboardButton([
                    'text' => '—',
                    'callback_data' => "query=productSpinner&order_id={$order->id}&product_id={$product->id}&type=down&img={$this->photo_index}"
                ]),
                new InlineKeyboardButton([
                    'text' => $orderProduct->quantity . ' шт.',
                    'callback_data' => time()
                ]),
                new InlineKeyboardButton([
                    'text' => '+',
                    'callback_data' => "query=productSpinner&order_id={$order->id}&product_id={$product->id}&type=up&img={$this->photo_index}"
                ]),
                new InlineKeyboardButton([
                    'text' => '❌',
                    'callback_data' => "query=deleteInCart&id={$orderProduct->id}&photo_index={$this->photo_index}"
                ]),
            ];
        } else {
            $keyboards[] = [
                new InlineKeyboardButton([
                    'text' => Yii::t('telegram/command', 'BUTTON_BUY', $this->number_format($product->getFrontPrice())),
                    'callback_data' => "query=addCart&product_id={$product->id}&photo_index={$this->photo_index}"
                ])
            ];
        }

        $keyboards[] = $this->productAdminKeywords($chat_id, $product->id);

        if ($images) {
            $imageData = $images[$this->photo_index];
            if ($imageData) {
                if ($imageData->telegram_file_id) {
                    $image = $imageData->telegram_file_id;
                } else {
                    $image = $imageData->getPathToOrigin();
                }

            } else {
                $image = Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . 'no-image.jpg';
            }
        } else {
            $image = Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . 'no-image.jpg';
        }


        $test = [

           // 'text' => json_encode($images),
            'chat_id' => $chat_id,
        ];
     //  Request::sendMessage($test);


        if ($callbackData == 'changeProductImage') {

            $dataMedia = [
                'chat_id' => $user_id,
                'message_id' => $message->getMessageId(),
                'media' => new InputMediaPhoto([
                    'media' => $image
                ]),
            ];

            $dataCaption = [
                'chat_id' => $user_id,
                'message_id' => $message->getMessageId(),
                'caption' => $caption,
                'parse_mode' => 'Markdown',
                'reply_markup' => new InlineKeyboard([
                    'inline_keyboard' => $keyboards
                ])
            ];

            $reqMedia = Request::editMessageMedia($dataMedia);
            if ($reqMedia->isOk()) {
                if (isset($imageData)) {
                    if (!$imageData->telegram_file_id) {
                        //todo: добавить проверку на бота, ИД или токен, еще не ясно
                        $imageData->telegram_file_id = $reqMedia->getResult()->photo[0]['file_id'];
                        $imageData->save(false);
                    }
                }
                //$this->notify(json_encode($reqMedia->getResult()), 'error');
            } else {
                $errorCode = $reqMedia->getErrorCode();
                $description = $reqMedia->getDescription();
                $this->notify("{$errorCode} {$description} " . $image, 'error');

            }
            $reqCaption = Request::editMessageCaption($dataCaption);

            if (!$reqCaption->isOk()) {
                $errorCode = $reqCaption->getErrorCode();
                $description = $reqCaption->getDescription();
                $this->notify("{$errorCode} {$description} " . $image, 'error');
            }

            return $reqCaption;

        } elseif ($callbackData == 'deleteInCart' || $callbackData == 'addCart' || $callbackData == 'productSpinner') {
            $dataEdit['chat_id'] = $chat_id;
            $dataEdit['message_id'] = $message->getMessageId();
            $dataEdit['reply_markup'] = new InlineKeyboard([
                'inline_keyboard' => $keyboards
            ]);
            return Request::editMessageReplyMarkup($dataEdit);
        } else {
            // $image = Url::to($product->getImage()->getUrlToOrigin(), true);

            $dataPhoto = [
                //'photo' => Url::to($product->getImage()->getUrl('800x800'), true),
                'photo' => $image,
                'chat_id' => $chat_id,
                'parse_mode' => 'Markdown',
                'caption' => $caption,
                'reply_markup' => new InlineKeyboard([
                    'inline_keyboard' => $keyboards
                ]),
            ];

            $reqPhoto = Request::sendPhoto($dataPhoto);
            if ($reqPhoto->isOk()) {

                if (isset($imageData)) {
                    if (!$imageData->telegram_file_id) {
                        $imageData->telegram_file_id = $reqPhoto->getResult()->photo[0]['file_id'];
                        $imageData->save(false);
                    }
                }
            } else {
                $errorCode = $reqPhoto->getErrorCode();
                $description = $reqPhoto->getDescription();
                //print_r($reqPhoto);
                $s = $this->notify("sendPhoto: {$errorCode} {$description} " . $image, 'error');
            }

            //
        }


        return Request::emptyResponse();
    }

    protected $_attributes;
    public $model;
    protected $_models;

    public function attributes($product)
    {

        $eav = $product;
        /** @var \app\modules\shop\components\EavBehavior $eav */
        $this->_attributes = $eav->getEavAttributes();


        $data = [];
        foreach ($this->getModels() as $model) {
            /** @var Attribute $model */
            $abbr = ($model->abbreviation) ? ' ' . $model->abbreviation : '';


            $data[$model->title]['value'] = $model->renderValue($this->_attributes[$model->name]);
            $data[$model->title]['abbreviation'] = $abbr;
        }

        return $data;

    }

    public function getModels()
    {
        if (is_array($this->_models))
            return $this->_models;

        $this->_models = [];
        //$cr = new CDbCriteria;
        //$cr->addInCondition('t.name', array_keys($this->_attributes));

        // $query = Attribute::getDb()->cache(function () {
        $query = Attribute::find()
            ->where(['IN', 'name', array_keys($this->_attributes)])
            ->sort()
            ->all();
        // }, 3600);


        foreach ($query as $m)
            $this->_models[$m->name] = $m;

        return $this->_models;
    }
}
