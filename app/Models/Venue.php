<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venue extends Model
{
    protected $fillable = [
        'description',
        'location',
        'contact'
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function socials(): HasMany
    {
        return $this->hasMany(Social::class);
    }
}
