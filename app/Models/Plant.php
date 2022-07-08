<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;
    protected $fillable = ['plantName', 'plantHeight', 'plantPhoto', 'genusId', 'familyId', 'orderId'];

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'plant_country', 'plantId', 'countryId');
    }
}
