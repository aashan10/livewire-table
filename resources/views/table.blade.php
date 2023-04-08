<?php $data = $this->data(); ?>
<?php
use LivewireTable\Helpers\ColumnHelper;
?>
<div class="w-full">
    <div class="w-full py-3">
        <div class="w-full flex justify-between align-middle">
            <h2 class="text-2xl font-extrabold">Filters</h2>
            <button class="rounded-full w-[60px] bg-white shadow-lg h-[60px] overflow-hidden flex justify-center items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24" fill="none">
                    <path fill-rule="evenodd" class="fill-indigo-500" clip-rule="evenodd" d="M2 5C2 3.34315 3.34315 2 5 2H19C20.6569 2 22 3.34315 22 5V6.17157C22 6.96722 21.6839 7.73028 21.1213 8.29289L15.2929 14.1213C15.1054 14.3089 15 14.5632 15 14.8284V17.1716C15 17.9672 14.6839 18.7303 14.1213 19.2929L11.9193 21.4949C10.842 22.5722 9 21.8092 9 20.2857V14.8284C9 14.5632 8.89464 14.3089 8.70711 14.1213L2.87868 8.29289C2.31607 7.73028 2 6.96722 2 6.17157V5Z"/>
                </svg>
            </button>
        </div>
        <div class="grid grid-cols-4 gap-2 transition-all">
            @foreach(ColumnHelper::getDataColumns($this->columns()) as $key => $column)
                @if (method_exists($column, 'isFilterable') && $column->isFilterable())
                    <input class="w-full rounded text-indigo-500 border-2 font-semibold" type="text" wire:model="filters.{{ $column->key() }}" aria-label="Filter by {{ $column->label() }}" placeholder="Filter by {{ $column->label() }}" />
                @endif
            @endforeach
        </div>
    </div>
    <div class="w-full pb-3 flex justify-between items-center">
        <input type="text" wire:model="searchQuery" aria-label="Search" placeholder="Search" class="rounded border-2 font-semibold w-full max-w-md" />
        <div wire:loading class="h-[40px] w-[40px]">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                <circle cx="50" cy="50" class="stroke-indigo-500" fill="none" stroke-width="8" r="45" stroke-dasharray="212.05750411731105 72.68583470577035">
                    <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"/>
                </circle>
            </svg>
        </div>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg relative">
        <table class="w-full text-sm text-left text-gray-500  rounded-lg">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
            <tr>
                @foreach(ColumnHelper::getDataColumns($this->columns()) as $column)
                    <?php $isSortable = method_exists($column, 'isSortable') &&  $column->isSortable(); ?>
                    <td @if($isSortable) wire:click="sortBy('{{ $column->key() }}')" @endif class="px-6 text-[14px] py-3 text-indigo-500 font-bold uppercase {{ $isSortable ? 'cursor-pointer' : '' }}">
                        {{ $column->label() }}
                    </td>
                @endforeach

                @foreach(ColumnHelper::getActionColumns($this->columns()) as $column)
                    <th scope="col" class="px-6 py-3 text-md font-semibold uppercase">
                        {{ $column->label() }}
                    </th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($data as $row)
                <tr class="bg-white border-b hover:bg-gray-50">
                    @foreach($this->columns() as $column)
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ method_exists($column, 'transform') ? $column->transform($row) : $column->label()}}
                        </td>
                    @endforeach
                </tr>
            @endforeach

            </tbody>
        </table>
        <div class="m-2">
            {{ $data->links() }}
        </div>
    </div>
</div>
