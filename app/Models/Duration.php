<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Duration extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kost_id',
        'type',
        'price',

    ];

    // Relationships

    public function kost(): BelongsTo
    {
        return $this->belongsTo(Kost::class);
    }


}
