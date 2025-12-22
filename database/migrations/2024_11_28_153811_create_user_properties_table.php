<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('user_properties', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');  // ربط البيانات مع المستخدم
        $table->string('full_name')->nullable();  // الاسم الكامل
        $table->integer('age')->nullable();  // العمر
        $table->string('marital_status')->nullable();  // الحالة الاجتماعية
        $table->string('occupation')->nullable();  // الوظيفة
        $table->integer('family_size')->nullable();  // عدد الأفراد في المنزل
        $table->decimal('monthly_income', 10, 2)->nullable();  // الدخل الشهري
        $table->string('preferred_location')->nullable();  // الموقع المفضل
        $table->string('lifestyle')->nullable();  // الأنشطة والاهتمامات
        $table->string('climate_preference')->nullable();  // التفضيلات المناخية
        $table->string('family_status')->nullable();  // حالة الأسرة (إذا كان لديه أطفال)
        $table->boolean('special_needs')->default(false);  // احتياجات خاصة
        $table->boolean('transport_nearby')->default(false);  // تفضيل وسائل النقل العامة
        $table->timestamps();

        // ربط `user_id` مع `users` table
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_properties');
    }
};
