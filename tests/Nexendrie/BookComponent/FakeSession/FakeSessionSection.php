<?php
declare(strict_types=1);

namespace Nexendrie\BookComponent\FakeSession;

/**
 * @internal
 */
class FakeSessionSection extends \Nette\Http\SessionSection
{
    /**
     * @var mixed[]
     */
    private array $data = [];

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->data);
    }

    public function set(string $name, mixed $value, ?string $expire = null): void
    {
        $this->data[$name] = $value;
    }

    public function get(string $name): mixed
    {
        return $this->data[$name] ?? null;
    }

    public function remove(array|string|null $name = null): void
    {
        if ($name === null) {
            $this->data = [];
        } else {
            foreach ((array) $name as $key) {
                unset($this->data[$key]);
            }
        }
    }

    public function __set(string $name, mixed $value): void
    {
        $this->set($name, $value);
    }

    public function &__get(string $name): mixed
    {
        return $this->data[$name];
    }

    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }

    public function __unset(string $name): void
    {
        $this->remove($name);
    }

    public function setExpiration(?string $expire, array|string|null $variables = null): static
    {
        return $this;
    }

    public function removeExpiration(array|string|null $variables = null): void
    {
    }
}
