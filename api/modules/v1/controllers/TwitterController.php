<?php

namespace api\modules\v1\controllers;

use TwitterAPIExchange;
use yii\rest\Controller;

/**
 * Class TwitterController
 * @package api\modules\v1\controllers
 */
class TwitterController extends Controller
{
    /**
     * @var array
     */
    private $settings = [];

    /**
     * TwitterController constructor.
     *
     * @param $id
     * @param $module
     * @param array $config
     */
    public function __construct($id, $module, $config = [])
    {
        $this->settings = \Yii::$app->params['twitterTokens'];
        parent::__construct($id, $module, $config);
    }

    /**
     * Add user
     *
     * @param $user string
     * @return string
     * @throws \Exception
     */
    public function actionAdd($user)
    {
        $id = $this->generateRandomString();
        $secret = sha1($id . $user);
        $url = 'https://api.twitter.com/1.1/add';
        $getfield = "?id={$id}&user={$user}&secret={$secret}";
        $requestMethod = 'GET';
        $twitter = new TwitterAPIExchange($this->settings);

        return $twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();
    }

    /**
     * Remove user
     *
     * @param $user string
     * @return string
     * @throws \Exception
     */
    public function actionRemove($user)
    {
        $id = $this->generateRandomString();
        $secret = sha1($id . $user);
        $url = 'https://api.twitter.com/1.1/remove';
        $getfield = "?id={$id}&user={$user}&secret={$secret}";
        $requestMethod = 'GET';
        $twitter = new TwitterAPIExchange($this->settings);

        return $twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();
    }

    /**
     * Get recent tweets
     *
     * @return string
     * @throws \Exception
     */
    public function actionFeed()
    {
        $id = $this->generateRandomString();
        $secret = sha1($id);
        $url = 'https://api.twitter.com/1.1/feed';
        $getfield = "?id={$id}&secret={$secret}";
        $requestMethod = 'GET';
        $twitter = new TwitterAPIExchange($this->settings);

        return $twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();
    }

    /**
     * Generate random string
     *
     * @param int $length
     * @return string
     */
    private function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

}