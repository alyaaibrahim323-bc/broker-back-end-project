<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'type', 'developer_id', 'size', 'price', 'down_payment',
        'installment_options', 'location', 'description', 'rooms', 'bathrooms',
        'images', 'location_link', 'list_of_description', 'has_garden',
        'garden_size', 'has_roof', 'roof_size', 'status', 'property_name','lat','lng', 'unit_key' // أضف هذا

    ];
    protected $casts = [
        'installment_options' => 'array',
        'images' => 'array',
        'list_of_description' => 'array',
        'has_garden' => 'boolean',
        'has_roof' => 'boolean',
    ];
    protected static function booted()
{
    static::created(function ($unit) {
        // تحديث العمود unit_key بعد إنشاء السجل
        $unit->update([
            'unit_key' => $unit->id
        ]);
    });
}
    public function salespeople()
    {
        return $this->belongsToMany(SalesUnit::class, 'sales_units')
                    ->withPivot('assigned_date', 'status')
                    ->withTimestamps();
    }
    public function salesUnits()
    {
        return $this->belongsToMany(Sales::class, 'sales_units')
                    ->withPivot('assigned_date', 'status')
                    ->withTimestamps();
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function sales()
    {
        return $this->belongsToMany(Sales::class, 'sales_units', 'unit_id', 'sales_id')
            ->withPivot('assigned_date', 'status') // إذا كنت بحاجة إلى البيانات من الجدول الوسيط
            ->withTimestamps(); // إذا كنت بحاجة إلى تتبع الوقت
    }
public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites', 'unit_id', 'user_id')->withTimestamps();
    }

public function developer()
    {
        return $this->belongsTo(Developer::class); // يشير إلى المطور المرتبط بالوحدة
    }

}
