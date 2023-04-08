<?php

namespace LivewireTable\Table;

use LivewireTable\Actions\FilterActionInterface;
use LivewireTable\Actions\SearchActionInterface;
use LivewireTable\Actions\TransformActionInterface;

class Column extends AbstractColumn implements DataColumnInterface
{
    private ?\Closure $searchClosure = null;
    private ?\Closure $filterClosure = null;
    private ?\Closure $transformClosure = null;

    private function __construct(
        protected string $key,
        protected string $label,
        protected bool $searchable = false,
        protected bool $sortable = false,
        protected bool $filterable = false
    ) {
        parent::__construct($this->key, $this->label);
    }

    public function searchable(bool $value = true): static
    {
        $this->searchable = $value;
        return $this;
    }

    public function filterable(bool $value = true): static
    {
        $this->filterable = $value;
        return $this;
    }
    public function sortable(bool $value = true): static
    {
        $this->sortable = $value;
        return $this;
    }

    public function transform($row): string
    {
        if ($this->transformClosure) {
            $closure = $this->transformClosure;

            return $closure($this, $row);
        }

        if (is_array($row) && isset($row[$this->key])) {
            return $row[$this->key];
        }

        if (is_object($row)) {
            try {
                return $row->{$this->key};
            } catch (\Exception $e) {}
        }

        return $row;
    }

    public function onSearch(callable|string $action): static
    {
        if (is_string($action) && class_exists($action)) {
            $action = app()->get($action);
            if (!$action instanceof SearchActionInterface) {
                throw new \Exception(sprintf('Class %s must be instance of %s', $action::class, SearchActionInterface::class));
            }
        }

        $this->searchClosure = $action(...);
        return $this;
    }

    public function onFilter(callable|string $action): static
    {
        if (is_string($action) && class_exists($action)) {
            $action = app()->get($action);
            if (!$action instanceof FilterActionInterface) {
                throw new \Exception(sprintf('Class %s must be instance of %s', $action::class, FilterActionInterface::class));
            }
        }

        $this->filterClosure = $action(...);
        return $this;
    }

    public function onTransform(callable|string $action): static
    {
        if (is_string($action) && class_exists($action)) {
            $action = app()->get($action);
            if (!$action instanceof TransformActionInterface) {
                throw new \Exception(sprintf('Class %s must be instance of %s', $action::class, TransformActionInterface::class));
            }
        }

        $this->transformClosure = $action(...);
        return $this;
    }

    public function searchClosure(): ?\Closure
    {
        return $this->searchClosure;
    }

    public function filterClosure(): ?\Closure
    {
        return $this->filterClosure;
    }

    public function transformClosure(): ?\Closure
    {
        return $this->transformClosure;
    }
    public function isSortable(): bool
    {
        return $this->sortable;
    }

    public function isSearchable(): bool
    {
        return $this->searchable && $this->searchClosure !== null;
    }

    public function isFilterable(): bool
    {
        return $this->filterable && $this->filterClosure !== null;
    }

    public static function make(string $key, string $value, bool $searchable = false, bool $sortable = false, bool $filterable = false): static
    {
        return new static($key, $value, $searchable, $sortable, $filterable);
    }
}
