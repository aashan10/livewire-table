<?php

namespace LivewireTable\Table;

use Livewire\Wireable;

final class Filters implements Wireable
{
    public function __construct(public array $filters = [])
    {}

    public function __set(string $name, $value): void
    {
        $this->filters[$name] = $value;
    }

    public function __get(string $name)
    {
        if (isset($this->filters[$name])) {
            return $this->filters[$name];
        }
        return null;
    }

    public function all(): array
    {
        return $this->filters;
    }

    public function count(): int
    {
        return count($this->filters);
    }

    public function toLivewire()
    {
        return $this->filters;
    }

    public static function fromLivewire($value)
    {
        return new self($value);
    }
}
