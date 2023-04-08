<?php

namespace LivewireTable\Actions;

use Illuminate\Database\Query\Builder;

interface ActionInterface
{
    public function __invoke(Builder $builder, $data);

}
