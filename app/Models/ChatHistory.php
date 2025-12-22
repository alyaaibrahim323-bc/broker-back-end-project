<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'role',
        'message',
        'user_id',
        'data',

    ];
// في موديل ChatHistory
public function user()
{
    return $this->belongsTo(User::class);
}
}
