<?php

namespace flyeralarm\ResellerApi\lib;

use \ArrayAccess as PHPArrayAccess;
use \Countable as PHPCountable;
use \Iterator as PHPIterator;
use flyeralarm\ResellerApi\exception\ArrayAccess as ArrayAccessException;

abstract class AbstractList implements PHPArrayAccess, PHPCountable, PHPIterator
{

    /**
     * @var array
     */
    protected $elements;

    /**
     * @var int
     */
    private $array_position = 0;

    /**
     * Initialize the protected elements property.
     */
    public function __construct()
    {
        $this->elements = array();
    }

    /**
     * Add an Item to the list.
     * @param mixed $item
     * @return void
     */
    abstract public function add($item);

    /**
     * Required for interface PHPArrayAccess.
     * @param mixed $offset
     * @return boolean
     *
     */
    final public function offsetExists($offset)
    {
        return isset($this->elements[$offset]);
    }

    /**
     * Required for interface PHPArrayAccess.
     * @param mixed $offset
     * @return mixed
     */
    final public function offsetGet($offset)
    {
        if (isset($this->elements[$offset])) {
            return $this->elements[$offset];
        } else {
            return null;
        }
    }

    /**
     * Required for interface PHPArrayAccess.
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    final public function offsetSet($offset, $value)
    {
        throw new ArrayAccessException();
    }

    /**
     * Required for interface PHPArrayAccess.
     * @param mixed $offset
     * @return void
     */
    final public function offsetUnset($offset)
    {
        unset($this->elements[$offset]);
    }

    /**
     * Required for interface PHPCountable.
     * @return int
     */
    final public function count()
    {
        return count($this->elements);
    }

    final public function current()
    {
        return $this->elements[$this->array_position];
    }


    final public function key()
    {
        return $this->array_position;
    }

    final public function next()
    {
        ++$this->array_position;
    }

    final public function rewind()
    {
        $this->array_position = 0;
    }

    final public function valid()
    {
        return isset($this->elements[$this->array_position]);
    }

}