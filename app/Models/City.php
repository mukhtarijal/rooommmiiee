<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'photo',
    ];


    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function kosts(): HasMany
    {
        return $this->hasMany(Kost::class);
    }
}
