<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان الإعلان
            $table->text('description'); // وصف الإعلان
            $table->string('image'); // مسار صورة الإعلان
            $table->unsignedBigInteger('developer_id');
            $table->string('phone_number'); // حقل رقم الهاتف
            $table->timestamps();
            $table->foreign('developer_id')->references('id')->on('developers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
