### Livewire Tables

Livewire tables is an add-on for your laravel/livewire project that lets you beautiful data tables within a matter of minutes.
It comes with Table and Column classes that handle the logic behind your data tables.

### Installation
```composer require aashan/livewire-table```

### Usage

After installing the package, here is a step-by-step guide on how you can use livewire table.

1. Create a class `UsersTable` inside the livewire components directory (app/Http/Livewire)
2. Open the `\App\Http\Livewire\UsersTable` class and make it as follows
   ```php
   class UsersTable extends \LivewireTable\Components\Table {
        protected function columns() : array{
            return [
                ...
            ];   
        }
   
        protected function builder(): \Illuminate\Database\Query\Builder {
             return \App\Models\User::query(); 
        }    
   }
   ```
3. Open the view where you want to show the table and add the livewire component name
   ```@livewire('users-table')```

That's it. You should see a table in your view. 

## But wait?
You might be wondering why the table is empty. It's because we haven't added any columns yet.
Remember the columns method that we just left empty? Now it's time to fill it up with actual columns. 
```php
protected function columns(): array
{
    return [
        \LivewireTable\Table\Column::make('id', 'ID'),
        \LivewireTable\Table\Column::make('name', 'Name'),
        \LivewireTable\Table\Column::make('email', 'Email'),
        \LivewireTable\Table\Column::make('created_at', 'Created At'),
    ]
}
``` 

Now when you re-fresh your page, you should be able to see the columns with their values.

### Making columns sortable, searchable and transforming data
Very easy, Just use `sortable`, `searchable` and `transform` methods on the column class.

Example:

```php

protected function columns(): array 
{
    return [
        \LivewireTable\Table\Column::make('id', 'ID')->sortable(),
        \LivewireTable\Table\Column::make('name', 'Name')
            ->sortable()
            ->searchable()
            -onSearch(fn (Builder $builder, $value) => $builder->where('name', 'like', '%' . $value . '%' )),
        \LivewireTable\Table\Column::make('email', 'Email')
            ->sortable()
            ->filterable()
            -onFilter(fn (Builder $builder, $value) => $builder->where('email', 'like', '%' . $value . '%' )),
    ]   
}
```
>**Warning**
>For `searchable` and `filterable` methods, they should always have `onSearch` and `onFilter` methods present within the column. If they are not present, searching and filtering won't work.

## API

- [\LivewireTable\Components\Table::class](\LivewireTable\Components\Table::class)
  - `public $perPage` - Determines the number of rows shown per page
- [\LivewireTable\Table\Column::class](\LivewireTable\Table\Column::class)
  - Properties
    - `$key`: Usually corresponds to the actual database column name
    - `$label`: UI heading for the database column
    - `$searchable`: Determines if the column is searchable
    - `$sortable`: Determines if the column is sortable
    - `$filterable`: Determines if the column is filterable
    - `$transformClosure`: Action Class name or closure that transforms the data
    - `$searchClosure`: Action Class name or closure that handles search results
    - `$filterClosure`: Similar to searchClosure, only difference is it handles filters
  - Methods
    - `public function searchable(bool $value = true): static`:
      Sets the `$searchable` property
    - `public function sortable(bool $value = true): static`:
      Sets the `$sortable` property
    - `public function filterable(bool $value = true): static`:
      Sets the `$filterable` property
    - `public function transform($row): string`: Transforms the given row with the transformation closure
    - `public function onSearch(callable|string $action): static`: Sets `$searchClosure` property      
    - `public function onFilter(callable|string $action): static`: Sets `$filtetrClosure` property      
    - `public function onTransform(callable|string $action): static`: Sets `$transformClosure` property      
