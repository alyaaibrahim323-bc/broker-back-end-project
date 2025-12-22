<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'contact_info',
        'location',
        'description',
        'image'
    
    
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function units()
{
    return $this->hasMany(Unit::class);
}

public function ads()
{
    return $this->hasMany(Ad::class);
}

public function offers()
{
    return $this->hasMany(Offer::class);
}

}
