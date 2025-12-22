<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * تشغيل المايجريشن.
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ربط الحجز بالمستخدم
            $table->foreignId('property_id')->constrained('units')->onDelete('cascade'); // ربط الحجز بالعقار (الوحدة)
            $table->timestamp('viewing_date')->nullable(); // تاريخ المعاينة
            $table->timestamp('booking_date')->nullable(); // تاريخ الحجز النهائي
            $table->enum('status', ['Pending', 'Confirmed', 'Cancelled'])->default('Pending'); // حالة الحجز
            $table->boolean('is_final_booking')->default(false); // هل الحجز نهائي؟
            $table->timestamps(); // لتسجيل وقت الإنشاء والتحديث
        });
    }

    /**
     * التراجع عن المايجريشن.
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
