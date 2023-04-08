<?php

namespace LivewireTable\Traits;

use Illuminate\Support\Collection;
use LivewireTable\Table\DataColumnInterface;

trait WithSearch
{
    public string $searchQuery = '';
    private function getSearchableColumns(): Collection
    {
        return collect($this->columns())->filter(
            fn($column) => $column instanceof DataColumnInterface && $column->searchable() && $column->searchClosure() !== null
        );
    }

    public function resetSearchQuery(): void
    {
        $this->reset('searchQuery');
    }
    abstract public function columns(): array;
    abstract public function reset(...$properties);
}
