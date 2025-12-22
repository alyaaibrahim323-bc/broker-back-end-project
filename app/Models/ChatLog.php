<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_message', 'ai_response', 'user_id','conversation','session_id']; // الأعمدة التي يمكن ملؤها

    // العلاقة مع نموذج User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
