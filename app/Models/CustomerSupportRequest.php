<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerSupportRequest extends Model
{
    protected $fillable = ['user_id', 'message', 'status'];

    // العلاقة بين طلب الدعم الفني والمستخدم
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // يشير إلى جدول users
    }
}
