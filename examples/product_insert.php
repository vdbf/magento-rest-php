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

echo $connector->post(
    'products',
    array(
        'json' => array(
            'type_id' => 'simple',
            'attribute_set_id' => 4,
            'sku' => '1232',
            'name' => 'TestProduct',
            'price' => '200',
            'status' => 1,
            'weight' => '0.5',
            'visibility' => 4,
            'tax_class_id' => 2,
            'description' => 'Test Product',
            'short_description' => 'TP'
        )
    )
);