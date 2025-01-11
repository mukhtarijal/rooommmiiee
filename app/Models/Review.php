<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'kost_id',
        'rating',
        'review',
    ];


    public function tenant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tenant_id')->whereHas('roles', function($q){
            $q->where('name', 'tenant');
        });
    }

    public function kost(): BelongsTo
    {
        return $this->belongsTo(Kost::class);
    }
}
