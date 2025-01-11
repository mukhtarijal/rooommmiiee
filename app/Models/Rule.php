<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'rule',
        'icon',
    ];

    public function kosts(): BelongsToMany
    {
        return $this->belongsToMany(Kost::class, 'kost_rule');
    }
}
