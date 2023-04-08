<?php

namespace LivewireTable\Table;

interface ActionColumnInterface extends ColumnInterface
{

    public function onAction(callable|string $closure);

}
