<?php

namespace LivewireTable\Components;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use LivewireTable\Table\Column;
use LivewireTable\Table\Filters;
use LivewireTable\Traits\WithFilters;
use LivewireTable\Traits\WithSearch;
use LivewireTable\Traits\WithSorting;

abstract class Table extends Component
{
    use WithPagination;
    use WithSearch;
    use WithFilters;
    use WithSorting;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->filters = new Filters([]);
    }

    public $perPage = 10;

    protected $rules = [
        'perPage' => 'number'
    ];
    /**
     * @return Column[]
     * @throws Exception
     */
    abstract protected function columns(): array;

    protected function actions(): array
    {
        return [

        ];
    }

    abstract protected function builder(): Builder;

    public function render(): View
    {
        return \view('livewire-table::table');
    }

    protected function data(): LengthAwarePaginator
    {
        $searchableColumns = $this->getSearchableColumns();
        $builder= $this->builder();
        if ($this->searchQuery !== '') {
            $searchableColumns->map(function (Column $column) use (&$builder) {
                $callable = $column->searchClosure();
                $builder = $callable($builder, $this->searchQuery);
            });
        }

        collect($this->filters->all())->filter(fn ($value) => !empty($value))
            ->map(function ($value, $key) use (&$builder) {
                /** @var Column $column */

                $column = collect($this->columns())->firstWhere(function (Column $column) use ($key) {
                    return $column->key() === $key;
                });

                if ($column && $column->isFilterable() && $column->filterClosure()) {
                    $closure = $column->filterClosure();
                    $builder = $closure($builder, $value);
                }
            });


        if ($this->sortBy && $this->sortOrder) {
            $builder->orderBy($this->sortBy, $this->sortOrder);
        }
        return $builder->paginate($this->perPage);
    }

    public function clearFilters(): void
    {
        $this->resetSearchQuery();
        $this->resetFilters();
        $this->reset('page');
    }
}
