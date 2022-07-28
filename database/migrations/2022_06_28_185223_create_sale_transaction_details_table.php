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
        Schema::create('sale_transaction_details', function (Blueprint $table) {
            $table->id();
            $table->char("sale_transaction_id", 18);
            $table->char("counter_item_id", 10);
            $table->integer("sale_transaction_quantity");
            $table->integer("subtotal");
            $table->timestamps();

            $table->foreign("sale_transaction_id")
                ->references("sale_transaction_id")
                ->on("sale_transactions")->onDelete("cascade");

            $table->foreign("counter_item_id")
                ->references("counter_item_id")
                ->on("counter_items")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_transaction_details');
    }
};
