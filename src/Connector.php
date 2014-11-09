<?php namespace Vdbf\Magento;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

/**
 * Class Connector
 * @package Vdbf\Magento
 */
class Connector
{

    /**
     * @var array
     */
    protected $config;

    /**
     * @var ClientInterface
     */
    protected $client;

    public function __construct($config, ClientInterface $client)
    {
        $this->config = $config;
        $this->client = $client;

        if (isset($this->config['auth'])) {
            $this->registerAuthSubscriber($this->config['auth']);
        }
    }

    public function get($url, $options = array())
    {
        $request = $this->createRequest('GET', $url, $options);
        return $this->handleRequest($request);
    }

    public function post($url, $options = array())
    {
        $request = $this->createRequest('POST', $url, $options);
        return $this->handleRequest($request);
    }

    protected function handleRequest(Request $request)
    {
        if (!isset($this->config['batch'])) {
            return $this->client->send($request);
        }
        return $request;
    }

    public function createRequest($method, $url, $options)
    {
        return $this->client->createRequest($method, $url, $options);
    }

    protected function registerAuthSubscriber($credentials)
    {
        $subscriber = new Oauth1($credentials);
        $this->client->getEmitter()->attach($subscriber);
    }


} 