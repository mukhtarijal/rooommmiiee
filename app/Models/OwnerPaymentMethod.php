<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OwnerPaymentMethod extends Model
{
    protected $fillable = [
        'owner_id',
        'payment_method_id',
        'account_number',
        'account_name',
    ];

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
