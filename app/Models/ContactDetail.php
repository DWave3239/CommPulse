<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactDetail extends Model
{
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function gigs(): HasMany
    {
        return $this->hasMany(Gig::class);
    }

    public function correspondences(): HasMany
    {
        return $this->hasMany(Correspondence::class);
    }
}
