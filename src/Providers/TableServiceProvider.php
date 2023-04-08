<?php

namespace LivewireTable\Providers;

use LivewireTable\Components\Table;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class TableServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
//        Livewire::component('table', Table::class);
        $this->publishes([
            __DIR__ . '/../../config/livewire-table.php' => config_path('livewire-table.php'),
        ]);

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'livewire-table');

    }

}
