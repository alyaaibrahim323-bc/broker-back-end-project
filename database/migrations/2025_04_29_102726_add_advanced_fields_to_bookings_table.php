<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->after('property_id');
            $table->string('project_name')->nullable()->after('phone_number');
            $table->decimal('price', 12, 2)->nullable()->after('project_name');
            $table->string('developer_name')->nullable()->after('price');
            $table->json('sales_list')->nullable()->after('developer_name');
            $table->text('notes')->nullable()->after('sales_list');
            $table->json('list_of_actions')->nullable()->after('notes');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'phone_number',
                'project_name',
                'price',
                'developer_name',
                'sales_list',
                'notes',
                'list_of_actions'
            ]);
        });
    }
};