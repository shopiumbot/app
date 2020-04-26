<?php

namespace app\modules\user\components;

use panix\engine\CMS;
use Yii;
use yii\db\Connection;
use yii\web\User;

/**
 * User component
 */
class WebUser extends User
{

    /**
     * @inheritdoc
     */
    public $identityClass = 'app\modules\user\models\User';

    /**
     * @inheritdoc
     */
    public $enableAutoLogin = true;

    /**
     * @inheritdoc
     */
    public $loginUrl = ["/user/login"];

    /**
     * Check if user is logged in
     *
     * @return bool
     */
    public function getIsLoggedIn()
    {
        return !$this->getIsGuest();
    }

    /**
     * @param \app\modules\user\models\User $identity
     * @inheritdoc
     */
    public function afterLogin($identity, $cookieBased, $duration)
    {
        $identity->updateLoginMeta();
        parent::afterLogin($identity, $cookieBased, $duration);
    }

    /**
     * Get user's display name
     *
     * @param string $default
     * @return string
     */
    public function getDisplayName($default = "username")
    {
        $user = $this->getIdentity();
        return $user ? $user->getDisplayName($default) : $this->username;
    }

    public function getLanguage()
    {
        $user = $this->getIdentity();
        return $user ? $user->language : "";
    }
    public function getClientDb()
    {
        $user = $this->getIdentity();
        return $user ? $user->getClientDb() : false;
    }
    public function getEmail()
    {
        $user = $this->getIdentity();
        return $user ? $user->email : "";
    }

    public function getTimezone()
    {
        $user = $this->getIdentity();
        //return $user ? $user->timezone : NULL;
    }



    public function getPhone()
    {
        $user = $this->getIdentity();
        return $user ? $user->phone : "";
    }

    public function getBanTime()
    {
        $user = $this->getIdentity();
        return $user ? $user->ban_time : false;
    }

    public function getBanReason()
    {
        $user = $this->getIdentity();
        return $user ? $user->ban_reason : false;
    }

    public function getUsername()
    {
        $user = $this->getIdentity();
        return $user ? $user->username : "";
    }

    /**
     * @param $size
     * @param array $options
     * @return string
     */
    public function getGuestAvatarUrl($size, $options = [])
    {
        return CMS::processImage($size, 'guest.png', '@uploads/users/avatars', $options);
    }

    /**
     * Check if user can do $permissionName.
     * If "authManager" component is set, this will simply use the default functionality.
     * Otherwise, it will use our custom permission system
     *
     * @param string $permissionName
     * @param array $params
     * @param bool $allowCaching
     * @return bool

    public function can($permissionName, $params = [], $allowCaching = true)
     * {
     * // check for auth manager to call parent
     * $auth = Yii::$app->getAuthManager();
     * if ($auth) {
     * return parent::can($permissionName, $params, $allowCaching);
     * }
     *
     * // otherwise use our own custom permission (via the role table)
     *
     * $user = $this->getIdentity();
     * return $user ? $user->can($permissionName) : false;
     * }*/

}
