<?php

namespace App\Query;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Session;

class ContactWithBand implements DataTableQuery
{
    public function apply(Builder $query): Builder
    {
        return $query->whereHas('band', function ($query) {
            $query->where('band_id', Session::get('currentBand'));
        });
    }
}
