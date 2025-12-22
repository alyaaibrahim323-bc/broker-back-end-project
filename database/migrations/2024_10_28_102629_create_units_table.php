<?php

// database/migrations/xxxx_xx_xx_create_units_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('type');
            $table->integer('size');
            $table->decimal('price', 10, 2);
            $table->string('location')->nullable();
            $table->string('location_link')->nullable(); // رابط موقع الوحدة
            $table->text('description')->nullable();
            $table->json('list_of_description')->nullable(); // قائمة من التفاصيل
            $table->json('images')->nullable(); // صور للوحدة
            $table->integer('bathrooms')->default(0);
            $table->integer('rooms')->default(0);
            $table->boolean('has_garden')->default(false); // يوجد حديقة
            $table->integer('garden_size')->nullable(); // مساحة الحديقة
            $table->boolean('has_roof')->default(false); // يوجد روف
            $table->integer('roof_size')->nullable(); // مساحة الروف
            $table->enum('status', ['available', 'reserved', 'sold'])->default('available'); // حالة الوحدة
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('units');
    }
}
