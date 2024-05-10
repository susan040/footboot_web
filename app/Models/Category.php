<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = ['image_url'];

    function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl();
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'category_id');
    }
}
