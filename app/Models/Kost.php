<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'description',
        'gender',
        'year_established',
        'room_size',
        'capacity',
        'available_rooms',
        'address',
        'city_id',
        'latitude',
        'longitude',
        'is_premium',
        'status',
    ];


    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function rules(): BelongsToMany
    {
        return $this->belongsToMany(Rule::class, 'kost_rule');
    }

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'kost_facility', 'kost_id', 'facility_id');
    }

    public function durations(): HasMany
    {
        return $this->hasMany(Duration::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function sewas(): HasMany
    {
        return $this->hasMany(Sewa::class);
    }

    public function kostAdvertisements(): HasMany
    {
        return $this->hasMany(KostAdvertisement::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
