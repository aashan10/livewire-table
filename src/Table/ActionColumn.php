<?php

namespace LivewireTable\Table;

class ActionColumn extends AbstractColumn implements ActionColumnInterface
{
    protected static string $type = ColumnInterface::TYPE_ACTION;

    protected \Closure $actionCallback;

    public function onAction(callable|string $closure): void
    {
        if (is_string($closure) && class_exists($closure)) {
            $closure = app()->get($closure);
        }

        $this->actionCallback = $closure(...);
    }


    public static function make(string $key, string $value): static
    {
        return parent::make($key, $value);
    }
}
