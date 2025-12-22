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
        Schema::create('chat_histories', function (Blueprint $table) {
            $table->id(); // المعرف الأساسي
            $table->string('session_id'); // معرف الجلسة
            $table->enum('role', ['user', 'assistant']); // تحديد دور (مستخدم أو مساعد)
            $table->text('message'); // نص الرسالة
            $table->unsignedBigInteger('user_id')->nullable(); // معرف المستخدم (يمكن أن يكون فارغًا)
            $table->timestamps(); // تاريخ ووقت الإنشاء والتعديل

            // إضافة مفتاح خارجي إلى جدول المستخدمين
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_histories');
    }
};
