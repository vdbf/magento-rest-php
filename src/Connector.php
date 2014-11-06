<?php namespace Vdbf\Magento;
use Vdbf\Magento\Entity\EntityInterface;

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

    public function persist(EntityInterface $entity)
    {

    }

    public function findOne($entityName, Filter $filter)
    {

    }

    public function findMany($entityName, Filter $filter)
    {

    }

} 