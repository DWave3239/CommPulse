<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Correspondence extends Model
{
    public function contactDetail(): BelongsTo
    {
        return $this->belongsTo(ContactDetail::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
