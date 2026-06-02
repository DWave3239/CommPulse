<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Band extends Model
{
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
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
