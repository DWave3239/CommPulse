<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Table('band_user')]
class BandUser extends Pivot
{
    protected $table = 'band_user';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class);
    }
}
