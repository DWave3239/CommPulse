<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Correspondence extends Model
{
    public function contactDetail(): BelongsTo
    {
        return $this->belongsTo(ContactDetail::class);
    }
}
