<?php

// database/migrations/xxxx_xx_xx_create_projects_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('developer_id')->constrained('developers')->onDelete('cascade');
            $table->string('name');
            $table->string('location');
            $table->boolean('is_for_sale')->default(true); // للبيع أو للإيجار
            $table->integer('min_size'); // المساحات تبدأ من
            $table->decimal('down_payment', 10, 2); // المقدم
            $table->text('installment_options')->nullable(); // التقسيط
            $table->text('unit_types')->nullable(); // أنواع الوحدات
            $table->enum('status', ['under_construction', 'completed'])->default('under_construction'); // حالة المشروع
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
