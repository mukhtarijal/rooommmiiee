<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KostAdvertisement extends Model
{
    protected $fillable = [
        'kost_id',
        'promo_code',
        'promo_type',
        'promo_value',
        'advertisement_duration_id',
        'price',
        'start_date',
        'end_date',
        'promotional_photo',
        'payment_proof',
        'status',
    ];


    public function kost(): BelongsTo
    {
        return $this->belongsTo(Kost::class);
    }

    public function advertisementDuration(): BelongsTo
    {
        return $this->belongsTo(AdvertisementDuration::class);
    }

    protected static function booted()
    {
        // Check status saat model di-retrieve
        static::retrieved(function ($kostAdvertisement) {
            if ($kostAdvertisement->end_date < now() && $kostAdvertisement->status === 'active') {
                $kostAdvertisement->update(['status' => 'expired']);
                $kostAdvertisement->kost()->update(['is_premium' => false]);
            }
        });
    }
}
