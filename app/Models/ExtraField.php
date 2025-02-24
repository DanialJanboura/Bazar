<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraField extends Model
{
    protected $fillable = [
        'category_id', // assuming you're using this to link to a category
        'name',
        'label',
        'field_type',
        'options',
        'notes',
    ];
    protected $casts = [
        'options' => 'array',
    ];
    

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
