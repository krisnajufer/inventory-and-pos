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
        Schema::create('warehouse_request_details', function (Blueprint $table) {
            $table->id();
            $table->char('warehouse_request_id', 18);
            $table->char('item_id', 5);
            $table->char('warehouse_id', 5);
            $table->integer('warehouse_request_quantity');
            $table->string('warehouse_request_approval');
            $table->text('warehouse_request_reason');
            $table->timestamps();

            $table->foreign('warehouse_request_id')
                ->references('warehouse_request_id')
                ->on('warehouse_requests')->onDelete('cascade');

            $table->foreign('item_id')
                ->references('item_id')
                ->on('items')->onDelete('cascade');

            $table->foreign('warehouse_id')
                ->references('warehouse_id')
                ->on('warehouses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_request_details');
    }
};
