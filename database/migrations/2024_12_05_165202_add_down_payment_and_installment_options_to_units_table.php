<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('units', function (Blueprint $table) {
        $table->decimal('down_payment', 10, 2)->after('images')->nullable();
        $table->text('installment_options')->after('down_payment')->nullable();
    });
}

public function down()
{
    Schema::table('units', function (Blueprint $table) {
        $table->dropColumn(['down_payment', 'installment_options']);
    });
}

};
