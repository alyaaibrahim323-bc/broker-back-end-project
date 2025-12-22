<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('customer_support_requests', function (Blueprint $table) {
            $table->id(); // معرف فريد
            $table->unsignedBigInteger('user_id'); // معرف العميل
            $table->text('message'); // رسالة الدعم الفني
            $table->enum('status', ['Pending', 'Resolved', 'Closed'])->default('Pending'); // حالة الطلب
            $table->timestamps(); // created_at و updated_at

            // إضافة مفتاح أجنبي إذا كان هناك جدول customers
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_support_requests');
    }
};
