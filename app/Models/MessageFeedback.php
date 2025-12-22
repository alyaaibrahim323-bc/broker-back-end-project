<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageFeedback extends Model
{
    
        protected $table = 'message_feedbacks'; // ✅ تحديد اسم الجدول الصحيح

    protected $fillable = [
        'message_id',
        'user_id',
        'feedback_type',
        'comment'
    ];
}