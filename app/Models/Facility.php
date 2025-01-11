<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'icon',
    ];


    public function kosts(): BelongsToMany
    {
        return $this->belongsToMany(Kost::class, 'kost_facility', 'facility_id', 'kost_id');
    }
}
