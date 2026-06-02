<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gig extends Model
{
    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class);
    }
    
    public function contactDetail(): BelongsTo
    {
        return $this->belongsTo(ContactDetail::class);
    }

    public function songs(): HasMany
    {
        return $this->hasMany(Song::class);
    }
}
