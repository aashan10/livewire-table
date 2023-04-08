<?php

namespace LivewireTable\Actions;

use Illuminate\Database\Eloquent\Model;
use LivewireTable\Table\Column;

interface TransformActionInterface
{
    public function __invoke(Column $column, Model $row);
}
