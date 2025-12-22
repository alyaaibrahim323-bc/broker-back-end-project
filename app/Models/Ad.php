<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'image', 
        'developer_id',
        'phone_number'
    ];

    // علاقة الإعلانات مع المطور
    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }
}
