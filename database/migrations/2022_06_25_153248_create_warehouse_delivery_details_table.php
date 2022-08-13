<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_delivery_details', function (Blueprint $table) {
            $table->id();
            $table->char('warehouse_delivery_id', 19);
            $table->char('item_id', 5);
            $table->integer('warehouse_delivery_quantity');
            $table->string('warehouse_delivery_receipt');
            $table->date('warehouse_receipt_date');
            $table->timestamps();

            $table->foreign('warehouse_delivery_id')
                ->references('warehouse_delivery_id')
                ->on('warehouse_deliveries')->onDelete('cascade');

            $table->foreign('item_id')
                ->references('item_id')
                ->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_delivery_details');
    }
};
