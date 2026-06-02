<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Song extends Model
{
    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class);
    }

    public function gigs(): HasMany
    {
        return $this->hasMany(Gig::class);
    }
}
