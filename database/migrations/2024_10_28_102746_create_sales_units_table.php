<?php
// database/migrations/xxxx_xx_xx_create_sales_units_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesUnitsTable extends Migration
{
    public function up()
    {
        Schema::create('sales_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_id')->constrained('sales')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->date('assigned_date');
            $table->enum('status', ['negotiation', 'available', 'sold'])->default('available'); // حالة البيع
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales_units');
    }
}
