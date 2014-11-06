<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$credentials = array(
    'key' => '',
    'secret' => ''
);

$urls = array(
    'initiate' => 'https://magentohost/oauth/initiate?oauth_callback=',
    'callback' => 'https://magentohost/examples/oauth.php',
    'authorize' => 'https://magentohost/admin/oauth_authorize?oauth_token=',
    'token' => 'https://magentohost/oauth/token'
);

$requester = new \Vdbf\Magento\Auth\OAuthTokenRequester($credentials, $urls);
$requester->route(\Symfony\Component\HttpFoundation\Request::createFromGlobals());