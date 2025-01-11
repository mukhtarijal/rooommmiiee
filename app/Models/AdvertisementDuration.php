<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdvertisementDuration extends Model
{
    protected $fillable = [
        'duration',
        'price',
    ];

    public function kostAdvertisements(): HasMany
    {
        return $this->hasMany(KostAdvertisement::class);
    }
}
