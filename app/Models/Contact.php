<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class);
    }
    
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function contactDetails(): HasMany
    {
        return $this->hasMany(ContactDetail::class);
    }
}
