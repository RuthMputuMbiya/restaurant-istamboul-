<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'profiles';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'bio',
        'avatar',
        'phone',
        'address',
        'city',
        'country',
        'postal_code',
        'birth_date',
        'preferences',
        'dietary_restrictions',
        'favorite_dishes',
        'allergies',
        'newsletter_subscribed',
        'notification_settings',
        'language',
        'currency',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'preferences' => 'array',
        'dietary_restrictions' => 'array',
        'favorite_dishes' => 'array',
        'allergies' => 'array',
        'notification_settings' => 'array',
        'newsletter_subscribed' => 'boolean',
        'birth_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get user's full address.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->postal_code,
            $this->country,
        ]);
        
        return implode(', ', $parts);
    }

    /**
     * Check if user has dietary restrictions.
     */
    public function hasDietaryRestrictions(): bool
    {
        return !empty($this->dietary_restrictions) && count($this->dietary_restrictions) > 0;
    }

    /**
     * Check if user has allergies.
     */
    public function hasAllergies(): bool
    {
        return !empty($this->allergies) && count($this->allergies) > 0;
    }

    /**
     * Get user's age.
     */
    public function getAgeAttribute(): ?int
    {
        if (!$this->birth_date) {
            return null;
        }
        
        return $this->birth_date->age;
    }

    /**
     * Scope a query to only include newsletter subscribers.
     */
    public function scopeNewsletterSubscribers($query)
    {
        return $query->where('newsletter_subscribed', true);
    }

    /**
     * Update notification preferences.
     */
    public function updateNotificationSettings(array $settings): void
    {
        $this->notification_settings = array_merge($this->notification_settings ?? [], $settings);
        $this->save();
    }

    /**
     * Add favorite dish.
     */
    public function addFavoriteDish(string $dish): void
    {
        $favorites = $this->favorite_dishes ?? [];
        if (!in_array($dish, $favorites)) {
            $favorites[] = $dish;
            $this->favorite_dishes = $favorites;
            $this->save();
        }
    }

    /**
     * Remove favorite dish.
     */
    public function removeFavoriteDish(string $dish): void
    {
        $favorites = $this->favorite_dishes ?? [];
        $this->favorite_dishes = array_values(array_diff($favorites, [$dish]));
        $this->save();
    }

    /**
     * Check if dish is favorite.
     */
    public function isFavoriteDish(string $dish): bool
    {
        return in_array($dish, $this->favorite_dishes ?? []);
    }
}