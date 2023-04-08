<?php

namespace LivewireTable\Traits;

use Exception;
use Illuminate\Support\Collection;
use LivewireTable\Table\Column;
use LivewireTable\Table\DataColumnInterface;
use LivewireTable\Table\Filters;

trait WithFilters
{
    public Filters $filters;

    /**
     * @throws Exception
     */

    public function resetFilters(): void
    {
        $this->reset('filters');
    }

    public function getFilterableColumns(): Collection
    {
        return collect($this->columns())->filter(fn (Column $column) => $column->isFilterable());
    }
    abstract public function columns(): array;
    abstract public function reset(...$properties);

}
