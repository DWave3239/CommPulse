<?php

namespace App\Query;

use Illuminate\Database\Eloquent\Builder;

interface DataTableQuery
{
    public function apply(Builder $query): Builder;
}
