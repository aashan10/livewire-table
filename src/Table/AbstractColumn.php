<?php

namespace LivewireTable\Table;

abstract class AbstractColumn implements ColumnInterface
{
    protected static string $type = ColumnInterface::TYPE_DATA;
    public function isDataColumn(): bool
    {
        return self::$type === ColumnInterface::TYPE_DATA;
    }

    public function isAction(): bool
    {
        return self::$type === ColumnInterface::TYPE_ACTION;
    }

    public function __construct(protected string $key, protected string $label)
    {}

    public function key(): string
    {
        return $this->key;
    }

    public function label(): string
    {
        return $this->label;
    }

    public static function make(string $key, string $value): static
    {
        return new static($key, $value);
    }

}
