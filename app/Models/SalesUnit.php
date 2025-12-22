<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesUnit extends Model
{
    use HasFactory;

    
    protected $table = 'sales_units';

    protected $fillable = ['sales_id', 'unit_id', 'assigned_date', 'status'];

    public function sale()
    {
        return $this->belongsTo(Sales::class);
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'sales_units')
                    ->withPivot('assigned_date', 'status')
                    ->withTimestamps();
}


}
