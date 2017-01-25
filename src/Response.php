<?php

namespace Freema\HeurekaAPI;

/**
 * Description of HeurekaAPI response
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class Response implements ArrayAccess, IteratorAggregate, Countable {

    function __construct($arr) {
        if (isset($arr)) {
            foreach ($arr as $k => $v) {
                $name = str_replace('-', '_', $k);
                $this->$name = $v;
            }
        }
    }

    /**
     * @return array
     */
    public function toArray() {
        return (array) $this;
    }

    /////*  interfaces ArrayAccess, Countable & IteratorAggregate *\\\\\\\

    /**
     * @return integer
     */
    final public function count() {
        return count((array) $this);
    }

    /**
     * @return \ArrayIterator
     */
    final public function getIterator() {
        return new ArrayIterator($this);
    }

    /**
     * @param integer | string $nm
     * @param string $val
     */
    final public function offsetSet($nm, $val) {
        $this->$nm = $val;
    }

    /**
     * @param type $nm
     * @return type
     */
    final public function offsetGet($nm) {
        return $this->$nm;
    }

    final public function offsetExists($nm) {
        return isset($this->$nm);
    }

    final public function offsetUnset($nm) {
        unset($this->$nm);
    }

}
