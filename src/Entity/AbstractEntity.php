<?php namespace Vdbf\Magento\Entity;

use ArrayAccess;

/**
 * Class AbstractEntity
 * @package Vdbf\Magento\Entity
 */
abstract class AbstractEntity implements ArrayAccess, EntityInterface
{

    protected $attributes = array();

    public function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->attributes[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->attributes[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->attributes[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }

    /**
     * Determine if entity is new or not
     * @return bool
     */
    public function isNew()
    {
        return !$this->offsetExists('enitity_id');
    }

    /**
     * Return JSON representation of entity
     * @return string
     */
    public function toJSON()
    {
        return json_encode($this->attributes);
    }

    /**
     * Return array representation of entity
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }

} 