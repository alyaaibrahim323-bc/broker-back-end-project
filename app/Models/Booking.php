<?php
// ملف المودل App\Models\Booking
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'property_id',
        'status',
        'is_final_booking',
        'viewing_date',
        'booking_date',
        'phone_number',
        'project_name',
        'price',
        'developer_name',
        'notes',
        'list_of_actions'
    ];

    protected $casts = [
        'list_of_actions' => 'array',
        'is_final_booking' => 'boolean',
        'viewing_date' => 'datetime',
        'booking_date' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'property_id');
    }
}