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
        Schema::create('sale_transactions', function (Blueprint $table) {
            $table->char("sale_transaction_id", 18);
            $table->primary("sale_transaction_id");
            $table->char("counter_id", 5);
            $table->dateTime("sale_transaction_date");
            $table->integer("grand_total");
            $table->timestamps();

            $table->foreign("counter_id")
                ->references("counter_id")
                ->on("counters")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_transactions');
    }
};
