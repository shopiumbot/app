<?php

namespace app\modules\user\models;

use DrewM\MailChimp\MailChimp;
use panix\engine\CMS;
use Yii;
use panix\engine\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\helpers\Inflector;
use ReflectionClass;

/**
 * This is the model class for table "tbl_user".
 *
 * @property string $id
 * @property string $role
 * @property integer $status
 * @property string $email
 * @property string $new_email
 * @property string $username
 * @property string $phone
 * @property string $password
 * @property string $auth_key
 * @property string $api_key
 * @property string $login_ip
 * @property string $login_time
 * @property string $create_ip
 * @property string $create_time
 * @property string $update_time
 * @property string $ban_time
 * @property string $ban_reason
 * @property string $language
 * @property UserKey[] $userKeys
 * @property UserAuth[] $userAuths
 */
class User extends ActiveRecord implements IdentityInterface
{

    public $disallow_delete = [1];
    const MODULE_ID = 'user';
    const route = '/admin/user/default';
    /**
     * @var int Inactive status
     */
    const STATUS_INACTIVE = 0;

    /**
     * @var int Active status
     */
    const STATUS_ACTIVE = 1;

    /**
     * @var int Unconfirmed email status
     */
    const STATUS_UNCONFIRMED_EMAIL = 2;

    /**
     * @var array Permission cache array
     */
    protected $_access = [];
    public $password_confirm;
    public $new_password;
    public $role;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "{{%user}}";
    }

    public function getProfileUrl()
    {
        return ['/user/profile/view', 'id' => $this->id];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        // set initial rules
        $rules = [
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            // general email and username rules
            [['email', 'username', 'phone', 'token', 'bot_name'], 'string', 'max' => 255],
            [['email', 'username'], 'unique'],
            [['email', 'username', 'bot_name', 'token'], 'filter', 'filter' => 'trim'],
            [['email'], 'email'],
            ['image', 'file'],

            [['token', 'bot_name'], 'required', 'on' => ['profile']],

            ['new_password', 'string', 'min' => 4, 'on' => ['reset', 'change']],
            // [['username'], 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u', 'message' => Yii::t('user/default', '{attribute} can contain only letters, numbers, and "_"')],
            // password rules
            //[['newPassword'], 'string', 'min' => 3],
            //[['newPassword'], 'filter', 'filter' => 'trim'],
            [['new_password'], 'required', 'on' => ['reset', 'change']],
            [['password_confirm'], 'required', 'on' => ['reset', 'register']],

            [['password', 'token'], 'required', 'on' => ['register']],
            [['token'], 'validateBotToken', 'on' => ['register']],



            [['db_name','db_password','db_user','domain'], 'string', 'on' => ['db']],


            ['phone', 'panix\ext\telinput\PhoneInputValidator'],
            //[['password_confirm'], 'compare', 'compareAttribute' => 'new_password', 'message' => Yii::t('user/default', 'Passwords do not match')],
            [['password_confirm'], 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('user/default', 'PASSWORD_NOT_MATCH'), 'on' => 'register'],
            // account page
            //[['currentPassword'], 'required', 'on' => ['account']],
            //[['currentPassword'], 'validateCurrentPassword', 'on' => ['account']],

            // admin rules
            [['ban_time'], 'date', 'format' => 'php:Y-m-d H:i:s', 'on' => ['admin']],
            [['ban_reason'], 'string', 'max' => 255, 'on' => 'admin'],
            [['role', 'username', 'status'], 'required', 'on' => ['admin']],
        ];

        // add required rules for email/username depending on module properties
        $requireFields = ["requireEmail", "requireUsername"];
        foreach ($requireFields as $requireField) {
            if (Yii::$app->getModule("user")->$requireField) {
                $attribute = strtolower(substr($requireField, 7)); // "email" or "username"
                $rules[] = [$attribute, "required"];
            }
        }

        return $rules;
    }

    public function validateBotToken($attribute)
    {


        Yii::$app->setComponents([
            'telegram2' => [
                'class' => 'panix\mod\telegram\components\Telegram',
                'botToken' => $this->$attribute,
                'botUsername' => $this->bot_name,
            ]
        ]);

        $response = Yii::$app->telegram2->getMe();
        $result = json_decode($response);

        if ($result->ok) {
            return true;
        } else {
            $this->addError($attribute, $result->description);
        }

    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios['register_fast'] = ['username', 'email', 'phone'];
        $scenarios['register'] = ['username', 'email', 'password', 'password_confirm', 'token'];
        $scenarios['reset'] = ['new_password', 'password_confirm'];
        $scenarios['admin'] = ['role', 'username'];
        $scenarios['db'] = ['db_user', 'db_password','db_name','domain'];
        // $scenarios['profile'] = ['token', 'bot_name'];

        return $scenarios;
    }

    /**
     * Validate current password (account page)
     */
    public function validateCurrentPassword()
    {
        if (!$this->verifyPassword($this->currentPassword)) {
            $this->addError("currentPassword", "Current password incorrect");
        }
    }


    public function behaviors()
    {
        $a = [];
        $a['uploadFile'] = [
            'class' => '\panix\engine\behaviors\UploadFileBehavior',
            'files' => [
                'image' => '@uploads/user',
            ],
            'options' => [
                'watermark' => false
            ]
        ];
        return ArrayHelper::merge($a, parent::behaviors());
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'new_password' => self::t('NEW_PASSWORD'),
            'password_confirm' => self::t('PASSWORD_CONFIRM'),
            'role' => self::t('ROLE'),
        ]);
    }

    public function getRoles()
    {
        $result = [];
        foreach (Yii::$app->authManager->getRoles() as $role) {
            $result[$role->name] = (!empty($role->description)) ? $role->description : $role->name;
        }
        return $result;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSession()
    {
        return $this->hasOne(Session::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserKeys()
    {
        return $this->hasMany(UserKey::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAuths()
    {
        return $this->hasMany(UserAuth::class, ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(["api_key" => $token]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Verify password
     *
     * @param string $password
     * @return bool
     */
    public function verifyPassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        // hash new password if set
        if ($this->password && in_array($this->scenario,['reset','register'])) {

            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        }
        if ($this->scenario == 'reset') {
            $this->password = Yii::$app->security->generatePasswordHash($this->new_password);
        }
        // convert ban_time checkbox to date
        if ($this->ban_time) {
            $this->ban_time = date("Y-m-d H:i:s");
        }

        // ensure fields are null so they won't get set as empty string
        $nullAttributes = ["email", "username", "ban_time", "ban_reason"];
        foreach ($nullAttributes as $nullAttribute) {
            $this->$nullAttribute = $this->$nullAttribute ? $this->$nullAttribute : null;
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->role) {
            Yii::$app->authManager->revokeAll($this->id);
            if (is_array($this->role)) {
                foreach ($this->role as $role) {
                    Yii::$app->authManager->assign(Yii::$app->authManager->getRole($role), $this->id);
                }
            } elseif (is_string($this->role)) {
                Yii::$app->authManager->assign(Yii::$app->authManager->getRole($this->role), $this->id);
            }
        }

        if (Yii::$app->hasModule('mailchimp')) {
            /** @var MailChimp $mailchimp */
            $list = Yii::$app->settings->get('mailchimp', 'list_user');
            if ($list) {
                $mailchimp = Yii::$app->mailchimp->getClient();


                $result = $mailchimp->post('lists/' . $list . '/members', [
                    //'merge_fields' => [
                    //    'FNAME' => $fname,
                    //    'LNAME' => $lname
                    //],
                    'email_address' => $this->email,
                    'status' => 'subscribed',
                ]);

                if ($mailchimp->success()) {
                    // $class   = 'alert-success';
                    // $message = $result['email_address']. ' ' .$result['status'];
                } else {
                    // $class   = 'alert-warning';
                    // $message = $result['title'];
                }
            }


        }

        parent::afterSave($insert, $changedAttributes);
    }

    public function getGenderList()
    {
        return [$this::t('FEMALE'), $this::t('MALE')];
    }

    /**
     * Set attributes for registration
     *
     * @param string $userIp
     * @param string $status
     * @return static
     */
    public function setRegisterAttributes($userIp, $status = null)
    {
        // set default attributes
        $attributes = [
            "create_ip" => $userIp,
            "auth_key" => Yii::$app->security->generateRandomString(),
            "api_key" => Yii::$app->security->generateRandomString(),
            "status" => static::STATUS_ACTIVE,
        ];

        // determine if we need to change status based on module properties
        $emailConfirmation = Yii::$app->getModule("user")->emailConfirmation;
        $requireEmail = Yii::$app->getModule("user")->requireEmail;
        $useEmail = Yii::$app->getModule("user")->useEmail;
        if ($status) {
            $attributes["status"] = $status;
        } elseif ($emailConfirmation && $requireEmail) {
            $attributes["status"] = static::STATUS_INACTIVE;
        } elseif ($emailConfirmation && $useEmail && $this->email) {
            $attributes["status"] = static::STATUS_UNCONFIRMED_EMAIL;
        }

        // set attributes and return
        $this->setAttributes($attributes, false);
        return $this;
    }

    /**
     * Check and prepare for email change
     *
     * @return bool True if user set a `new_email`
     */
    public function checkAndPrepEmailChange()
    {
        // check if user is removing email address (only if Module::$requireEmail = false)
        if (trim($this->email) === "") {
            return false;
        }

        // check for change in email
        if ($this->email != $this->getOldAttribute("email")) {

            // change status
            $this->status = static::STATUS_UNCONFIRMED_EMAIL;

            // set `new_email` attribute and restore old one
            $this->new_email = $this->email;
            $this->email = $this->getOldAttribute("email");

            return true;
        }

        return false;
    }

    /**
     * Update login info (ip and time)
     *
     * @return bool
     */
    public function updateLoginMeta()
    {
        // set data
        $this->login_ip = Yii::$app->getRequest()->getUserIP();
        $this->login_time = date("Y-m-d H:i:s");
        //$this->setScenario('disallow-timestamp');
        // save and return
        return $this->save(false, ["login_ip", "login_time"]);
    }

    /**
     * Confirm user email
     *
     * @return bool
     */
    public function confirm()
    {
        // update status
        $this->status = static::STATUS_ACTIVE;

        // update new_email if set
        if ($this->new_email) {
            $this->email = $this->new_email;
            $this->new_email = null;
        }

        // save and return
        return $this->save(false, ["email", "new_email", "status"]);
    }

    /**
     * Check if user can do specified $permission
     *
     * @param string $permissionName
     * @param array $params
     * @param bool $allowCaching
     * @return bool
     */
    public function can22($permissionName, $params = [], $allowCaching = true)
    {
        // check for auth manager rbac
        $auth = Yii::$app->getAuthManager();
        if ($auth) {
            if ($allowCaching && empty($params) && isset($this->_access[$permissionName])) {
                return $this->_access[$permissionName];
            }
            $access = $auth->checkAccess($this->getId(), $permissionName, $params);
            if ($allowCaching && empty($params)) {
                $this->_access[$permissionName] = $access;
            }

            return $access;
        }

        // otherwise use our own custom permission (via the role table)
        return $this->role->checkPermission($permissionName);
    }

    /**
     * Get display name for the user
     *
     * @var string $default
     * @return string|int
     */
    public function getDisplayName($default = "")
    {
        // define possible fields
        $possibleNames = [
            "username",
            "email",
            "id",
        ];

        // go through each and return if valid
        foreach ($possibleNames as $possibleName) {
            if (!empty($this->$possibleName)) {
                return $this->$possibleName;
            }
        }

        return $default;
    }

    /**
     * Send email confirmation to user
     *
     * @param UserKey $userKey
     * @return int
     */
    public function sendEmailConfirmation($userKey)
    {
        /** @var $mailer \yii\swiftmailer\Mailer */
        /** @var $message \yii\swiftmailer\Message */

        // modify view path to module views
        $mailer = Yii::$app->mailer;
        $oldViewPath = $mailer->viewPath;
        $mailer->viewPath = Yii::$app->getModule("user")->emailViewPath;

        // send email
        $user = $this;
        $email = $user->new_email !== null ? $user->new_email : $user->email;
        $subject = Yii::t("user/default", "Email Confirmation");
        $message = $mailer->compose('confirmEmail', compact("subject", "user", "userKey"))
            ->setTo($email)
            ->setSubject($subject);

        // check for messageConfig before sending (for backwards-compatible purposes)
        if (empty($mailer->messageConfig["from"])) {
            $message->setFrom(Yii::$app->params["adminEmail"]);
        }
        $result = $message->send();

        // restore view path and return result
        $mailer->viewPath = $oldViewPath;
        return $result;
    }

    /**
     * Get list of statuses for creating dropdowns
     *
     * @return array
     */
    public static function statusDropdown()
    {
        // get data if needed
        static $dropdown;
        if ($dropdown === null) {

            // create a reflection class to get constants
            $reflClass = new ReflectionClass(get_called_class());
            $constants = $reflClass->getConstants();

            // check for status constants (e.g., STATUS_ACTIVE)
            foreach ($constants as $constantName => $constantValue) {

                // add prettified name to dropdown
                if (strpos($constantName, "STATUS_") === 0) {
                    // $prettyName = str_replace("STATUS_", "", $constantName);
                    // $prettyName = Inflector::humanize(strtolower($prettyName));
                    $dropdown[$constantValue] = self::t($constantName);
                }
            }
        }

        return $dropdown;
    }


    /**
     * @param bool $size
     * @param array $options
     * @return mixed|string
     */
    public function getAvatarUrl($size = false, $options = [])
    {
        if (preg_match('/(http|https):\/\/(.*?)$/i', $this->image)) {
            return $this->image;
        }
        $filesBehavior = $this->getBehavior('uploadFile');
        if ($this->image) {
            foreach ($filesBehavior->files as $attribute => $path) {
                return CMS::processImage($size, $this->image, $path, $options);
            }
        } else {
            return CMS::processImage($size, 'user.png', '@uploads/users/avatars', $options);
        }
    }

}
