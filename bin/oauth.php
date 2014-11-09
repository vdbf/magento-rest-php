<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$credentials = array(
    'key' => CONSUMER_KEY,
    'secret' => CONSUMER_SECRET
);

$urls = array(
    'initiate' => 'http://magento-test.dev/oauth/initiate?oauth_callback=',
    'callback' => 'http://magento-test.dev/bin/oauth.php',
    'authorize' => 'http://magento-test.dev/admin/oauth_authorize?oauth_token=',
    'token' => 'http://magento-test.dev/oauth/token'
);

$requester = new \Vdbf\Magento\Auth\OAuthTokenRequester($credentials, $urls);
$requester->route(\Symfony\Component\HttpFoundation\Request::createFromGlobals());