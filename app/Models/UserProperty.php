<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProperty extends Model
{
    use HasFactory;

    // تحديد اسم الجدول في قاعدة البيانات
    protected $table = 'user_properties';

    // تحديد الأعمدة التي يمكن ملؤها بشكل جماعي
    protected $fillable = [
        'user_id',
        'full_name',
        'age',
        'marital_status',
        'occupation',
        'family_size',
        'monthly_income',
        'preferred_location',
        'lifestyle',
        'climate_preference',
        'family_status',
        'special_needs',
        'transport_nearby'
    ];

    // ربط العلاقة مع جدول `users`public function user()

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
