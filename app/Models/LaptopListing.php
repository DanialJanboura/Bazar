<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaptopListing extends Model
{

    protected $fillable = [
        'model',
        'cpu',
        'ram',
        'storage',
        'gpu',
        'screen_size',
        'os',
    ];

    
    public function listing()
    {
        return $this->morphOne(Listing::class, 'listingable');
    }
}
