<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // حقل العنوان
            $table->text('description'); // حقل الوصف
            $table->string('image'); // حقل الصورة
            $table->unsignedBigInteger('developer_id'); // معرّف المطور
            $table->string('phone_number'); // حقل رقم الهاتف
            $table->timestamps();

            // إنشاء العلاقة مع جدول المطورين
            $table->foreign('developer_id')->references('id')->on('developers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
};
