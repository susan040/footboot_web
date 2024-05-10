<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'status',
        'role',
        'address',
    ];
    protected $appends = ['image_url'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl();
    }
    public function venues()
    {
        return $this->hasMany(Venue::class, 'vendor_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'vendor_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'vendor_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        try {
            $this->addMediaConversion('thumb')
                ->width(160)
                ->height(300);

            $this->addMediaConversion('medium')
                ->width(320)
                ->height(320);

        } catch (InvalidManipulation $e) {

        }
    }

    function getImage($collectionName = null)
    {
        if ($collectionName) {
            if (count($this->getMedia($collectionName)) == 0) return null;
            return $this->getFirstMediaUrl($collectionName ?? null);
        } else {
            if (count($this->getMedia()) == 0) return null;
            return $this->getFirstMediaUrl() ?? null;
        }
    }

    function getImageByIndex($index = 0)
    {
        if (count($this->getMedia()) == 0) return null;
//        if ($this->getMedia()->first()->getUrl('large') != null)
        try {
            return $this->getMedia()[$index]->getUrl() ?? null;
        } catch (\Exception $e) {
            return null;
        }
        return $this->getFirstMediaUrl() ?? null;
    }

    function getThumbnail($collectionName = null)
    {
        if ($collectionName) {
            if (count($this->getMedia($collectionName)) == 0) return null;
            return $this->getMedia($collectionName)->first()->getUrl('medium') ?? null;
        } else {
            if (count($this->getMedia()) == 0) return null;
            return $this->getMedia()->first()->getUrl('medium') ?? null;
        }
    }
}
