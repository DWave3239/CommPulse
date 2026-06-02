<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Social extends Model
{
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }
}
