<?php

namespace LivewireTable\Table;

interface ColumnInterface {

    const TYPE_DATA = 'data';
    const TYPE_ACTION = 'action';
    public function key(): string;
    public function label(): string;


    public static function make(string $key, string $value): static;

    public function isDataColumn(): bool;
    public function isAction(): bool;
}
