<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$connector = new \Vdbf\Magento\Connector(array(
    'auth' => array(
        'consumer_key' => CONSUMER_KEY,
        'consumer_secret' => CONSUMER_SECRET,
        'token' => TOKEN,
        'token_secret' => TOKEN_SECRET
    )
), new \GuzzleHttp\Client(array(
    'base_url' => 'http://magento-test.dev/api/rest/',
    'defaults' => array(
        'headers' => array(
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ),
        'auth' => 'oauth'
    )
)));

echo $connector->get('products')->getBody();