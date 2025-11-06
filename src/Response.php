<?php

declare(strict_types=1);

namespace Freema\HeurekaAPI;

use AllowDynamicProperties;
use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * Description of HeurekaAPI response
 *
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 * @implements ArrayAccess<string, mixed>
 * @implements IteratorAggregate<string, mixed>
 */
#[AllowDynamicProperties]
class Response implements ArrayAccess, IteratorAggregate, Countable
{
    /**
     * @param array<string, mixed>|null $arr
     */
    public function __construct(?array $arr)
    {
        if ($arr !== null) {
            foreach ($arr as $k => $v) {
                $name = str_replace('-', '_', $k);
                $this->$name = $v;
            }
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return (array) $this;
    }

    // Interfaces: ArrayAccess, Countable & IteratorAggregate

    public function count(): int
    {
        return count((array) $this);
    }

    /**
     * @return Traversable<string, mixed>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator((array) $this);
    }

    /**
     * @param string|null $offset
     * @param mixed $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($offset !== null && is_string($offset)) {
            $this->$offset = $value;
        }
    }

    /**
     * @param string $offset
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->$offset ?? null;
    }

    /**
     * @param string $offset
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->$offset);
    }

    /**
     * @param string $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->$offset);
    }
}
