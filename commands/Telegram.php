<?php

namespace app\commands;

use yii\authclient\OAuth2;


class Telegram extends OAuth2
{
    /**
     * {@inheritdoc}
     */
    public $authUrl = 'https://github.com/login/oauth/authorize';
    /**
     * {@inheritdoc}
     */
    public $tokenUrl = 'https://github.com/login/oauth/access_token';
    /**
     * {@inheritdoc}
     */
    public $apiBaseUrl = 'https://api.github.com';
    public $token;
    public $bot_name;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if ($this->scope === null) {
            $this->scope = 'user';
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function initUserAttributes()
    {
        $attributes = $this->api('user', 'GET');

        if (empty($attributes['email'])) {
            // in case user set 'Keep my email address private' in GitHub profile, email should be retrieved via extra API request
            $scopes = explode(' ', $this->scope);
            if (in_array('user:email', $scopes, true) || in_array('user', $scopes, true)) {
                $emails = $this->api('user/emails', 'GET');
                if (!empty($emails)) {
                    foreach ($emails as $email) {
                        if ($email['primary'] == 1 && $email['verified'] == 1) {
                            $attributes['email'] = $email['email'];
                            break;
                        }
                    }
                }
            }
        }

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    protected function defaultName()
    {
        return 'telegram';
    }

    /**
     * {@inheritdoc}
     */
    protected function defaultTitle()
    {
        return 'Telegram';
    }

    /**
     * {@inheritdoc}
     */
    public function applyAccessTokenToRequest($request, $accessToken)
    {
        $request->getHeaders()->add('Authorization', 'token ' . $accessToken->getToken());
    }
}
