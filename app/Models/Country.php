<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable = ['countryName'];

    public function plants()
    {
        $this->belongsToMany(Plant::class, 'plant_country', 'countryId', 'plantId');
    }
}
