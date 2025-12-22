<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldsToProjectsTable extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->text('about')->nullable();
            $table->decimal('average_meter_price_from', 10, 2)->nullable();
            $table->decimal('average_meter_price_to', 10, 2)->nullable();
            $table->decimal('unit_area_to', 10, 2)->nullable();
            $table->text('facilities')->nullable();
            $table->text('services')->nullable();
            $table->decimal('starting_price', 15, 2)->nullable();
            $table->decimal('maintenance_deposit_percentage', 5, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'about',
                'average_meter_price_from',
                'average_meter_price_to',
                'unit_area_to',
                'facilities',
                'services',
                'starting_price',
                'maintenance_deposit_percentage',
            ]);
        });
    }
}

