<?php

namespace LivewireTable\Traits;

trait WithSorting
{

    public string $sortOrder = 'desc';
    public ?string $sortBy = null;


    public function sortBy(string $key): void
    {
        if ($key === $this->sortBy) {
            $this->sortOrder = $this->sortOrder === 'desc' ? 'asc' : 'desc';
        } else {
            $this->sortBy = $key;
        }
    }

}
