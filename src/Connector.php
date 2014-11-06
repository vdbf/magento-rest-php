<?php namespace Vdbf\Magento;

/**
 * Class Connector
 * @package Vdbf\Magento
 */
class Connector {

    /**
     * @var array
     */
    protected $config;

    /**
     * @var ClientInterface
     */
    protected $client;

    public function __construct($config, $client)
    {
        $this->config = $config;
        $this->client = $client;
    }

} 