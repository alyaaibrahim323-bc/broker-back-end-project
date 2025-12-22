<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->decimal('downpayment', 8, 2)->after('phone_number'); // حقل 10% الدفعة الأولى بدون قيمة افتراضية
            $table->integer('installment_years')->after('downpayment'); // حقل سنوات الأقساط بدون قيمة افتراضية
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn('downpayment'); // حذف حقل الدفعة الأولى
            $table->dropColumn('installment_years'); // حذف حقل سنوات الأقساط
        });
    }
}
