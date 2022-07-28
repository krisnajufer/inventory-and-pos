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
        Schema::create('counter_delivery_details', function (Blueprint $table) {
            $table->id();
            $table->char('counter_delivery_id', 18);
            $table->char('item_id', 5);
            $table->integer('counter_delivery_quantity');
            $table->string('counter_delivery_receipt');
            $table->date('counter_receipt_date');
            $table->timestamps();

            $table->foreign('counter_delivery_id')
                ->references('counter_delivery_id')
                ->on('counter_deliveries')->onDelete('cascade');

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
        Schema::dropIfExists('counter_delivery_details');
    }
};
