<?php

namespace LivewireTable\Helpers;

use LivewireTable\Table\ColumnInterface;

class ColumnHelper
{

    /**
     * @param $columns
     * @return ColumnInterface[]
     */
    public static function getActionColumns($columns): array
    {
        return collect($columns)->filter(fn (ColumnInterface $column) => $column->isAction())->toArray();
    }

    /**
     * @param $columns
     * @return ColumnInterface[]
     */
    public static function getDataColumns($columns): array
    {
        return collect($columns)->filter(fn (ColumnInterface $column) => $column->isDataColumn())->toArray();
    }

}
