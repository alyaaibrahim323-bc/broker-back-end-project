<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToDevelopersTable extends Migration
{
    public function up()
    {
        Schema::table('developers', function (Blueprint $table) {
            $table->string('location')->nullable();       // حقل للمقر
            $table->text('description')->nullable();      // حقل للوصف
            $table->string('image')->nullable();          // حقل للصورة
        });
    }

    public function down()
    {
        Schema::table('developers', function (Blueprint $table) {
            $table->dropColumn(['location', 'description', 'image']);
        });
    }
}
