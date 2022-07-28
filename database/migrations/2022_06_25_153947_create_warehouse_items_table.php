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
        Schema::create('warehouse_items', function (Blueprint $table) {
            $table->char('warehouse_item_id', 10);
            $table->primary('warehouse_item_id');
            $table->string('slug');
            $table->char('warehouse_id', 5);
            $table->char('item_id', 5);
            $table->integer('stock_warehouse_item');
            $table->timestamps();

            $table->foreign('warehouse_id')
                ->references('warehouse_id')
                ->on('warehouses')->onDelete('cascade');

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
        Schema::dropIfExists('warehouse_items');
    }
};
