<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sewa extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'kost_id',
        'duration',
        'price',
        'promo_code',
        'start_date',
        'end_date',
        'payment_proof',
        'payment_forward',
        'status',
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
