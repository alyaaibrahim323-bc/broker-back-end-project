<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'developer_id',
        'phone_number',
        'downpayment',
        'installment_years'
    ];

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }
}
