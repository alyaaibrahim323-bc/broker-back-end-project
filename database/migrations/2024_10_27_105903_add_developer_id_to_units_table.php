<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            // إضافة عمود developer_id كمرجع للمطور المسؤول
            $table->unsignedBigInteger('developer_id')->nullable();
            
            // تعريف العلاقة الخارجية مع جدول developers
            $table->foreign('developer_id')->references('id')->on('developers')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            // إزالة العلاقة الخارجية وعمود developer_id
            $table->dropForeign(['developer_id']);
            $table->dropColumn('developer_id');
        });
    }
};
