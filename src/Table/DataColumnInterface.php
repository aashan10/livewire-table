<?php

namespace LivewireTable\Table;

interface DataColumnInterface extends ColumnInterface
{
    public function searchable(bool $value = true): static;
    public function filterable(bool $value = true): static;
    public function sortable(bool $value = true): static;

    public function transform($row): string;
    public function isSortable(): bool;
    public function isSearchable(): bool;
    public function isFilterable(): bool;

    public function onSearch(callable|string $action): static;
    public function onFilter(callable|string $action): static;
    public function onTransform(callable|string $action): static;

    public function searchClosure():?\Closure;
    public function filterClosure():?\Closure;

    public function transformClosure():?\Closure;

}
