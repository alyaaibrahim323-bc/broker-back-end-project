<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
    'developer_id',
     'name',
     'location',
     'is_for_sale',
     'min_size',
     'down_payment',
     'installment_options',
     'unit_types',
     'status',
     'image',
     'description',
     'about',
     'average_meter_price_from',
     'average_meter_price_to',
     'unit_area_to',
     'facilities',
     'services',
     'starting_price',
     'maintenance_deposit_percentage',
    ];



    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }
}
