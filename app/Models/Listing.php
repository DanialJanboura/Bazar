<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    // Allow mass assignment on these fields.
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'price',
        'condition',
        'location',
        'status',
        'extra_fields',
    ];

    protected $casts = [
        'extra_fields' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Each listing belongs to a category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function listingable()
    {
        return $this->morphTo();
    }


}
