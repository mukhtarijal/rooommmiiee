<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;


    /**
     * The attributes that are mass assignable.`
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'gender',
        'birth_place',
        'birth_date',
        'address',
        'city_id',
        'job',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    public function kosts(): HasMany
    {
        return $this->hasMany(Kost::class, 'owner_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function sewas(): HasMany
    {
        return $this->hasMany(Sewa::class, 'tenant_id');
    }

    public function chatsAsTenant(): HasMany
    {
        return $this->hasMany(Chat::class, 'tenant_id');
    }

    public function chatsAsOwner(): HasMany
    {
        return $this->hasMany(Chat::class, 'owner_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'tenant_id');
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class, 'user_id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'tenant_id');
    }

    public function ownerPaymentMethods(): HasMany
    {
        return $this->hasMany(OwnerPaymentMethod::class, 'owner_id');
    }

    /**
     * @throws Exception
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin' && $this->hasRole('admin')) {
            return true;
        }

        return $panel->getId() === 'owner' && $this->hasRole('owner');
    }
}
