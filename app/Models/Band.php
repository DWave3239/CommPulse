<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Band extends Model
{
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('admittance', 'exit', 'founding_member', 'position');
    }

    public function songs(): HasMany
    {
        return $this->hasMany(Song::class);
    }

    public function gigs(): HasMany
    {
        return $this->hasMany(Gig::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
