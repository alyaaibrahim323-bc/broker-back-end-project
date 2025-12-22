<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageFeedbacksTable extends Migration
{
    public function up()
    {
        Schema::create('message_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->uuid('message_id'); // يتطابق مع الـ UUID في الرسائل
            $table->unsignedBigInteger('user_id'); // المستخدم الذي أعطى التقييم
            $table->enum('feedback_type', ['like', 'dislike']);
            $table->text('comment')->nullable(); // حقل التعليق
            $table->timestamps();
            
            // مفاتيح خارجية
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // فهرسة لتحسين الأداء
            $table->index('message_id');
            $table->index(['message_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('message_feedbacks');
    }
}