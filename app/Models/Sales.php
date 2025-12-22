<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'sales_person_id',
        'sale_price',
        'email',
        'image',
        'name',
        'contact_info'
    ];

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'sales_units','sales_id','unit_id')
                    ->withPivot('assigned_date', 'status')
                    ->withTimestamps();
    }
    public function salesUnits()
    {
        return $this->hasMany(SalesUnit::class, 'unit_id', 'id');
    }
    

   

}
