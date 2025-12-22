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
    Schema::table('units', function (Blueprint $table) {
        // إضافة عمود جديد unit_key بنفس مواصفات id
        $table->unsignedBigInteger('unit_key')->after('id');
        
       
    });

    // نسخ قيم id الحالية إلى unit_key
    DB::statement('UPDATE units SET unit_key = id');
}

public function down()
{
    Schema::table('units', function (Blueprint $table) {
        $table->dropUnique(['unit_key']);
        $table->dropColumn('unit_key');
    });
}
};
