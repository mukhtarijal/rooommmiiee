<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'icon',
    ];

    public function roomiePaymentMethods(): HasMany
    {
        return $this->hasMany(RoomiePaymentMethod::class);
    }
    public function ownerPaymentMethods(): HasMany
    {
        return $this->hasMany(OwnerPaymentMethod::class);
    }
}
