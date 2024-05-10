<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = ['image_url'];

    public function vendor()
    {
        $this->belongsTo(User::class, 'vendor_id');
    }

    public function orders()
    {
        $this->hasMany(Order::class);
    }

    function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl();
    }
}
