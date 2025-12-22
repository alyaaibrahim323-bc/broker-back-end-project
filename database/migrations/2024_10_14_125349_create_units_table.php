<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('type'); 
            $table->integer('space'); 
            $table->decimal('price', 10, 2); 
            $table->string('location'); 
            $table->text('description')->nullable(); 
            $table->integer('rooms'); 
            $table->integer('bathrooms'); 
            $table->boolean('has_garden')->default(false); 
            $table->integer('garden_space')->nullable(); 
            $table->boolean('has_roof')->default(false); 
            $table->integer('roof_space')->nullable(); 
            $table->boolean('delivered')->default(false);
            $table->string('images')->nullable();
            $table->timestamps();
        });

       
    }

    public function down()
    {
        Schema::dropIfExists('developers');
        Schema::dropIfExists('units');
    }
};
