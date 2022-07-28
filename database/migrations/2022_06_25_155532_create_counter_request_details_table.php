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
        Schema::create('counter_request_details', function (Blueprint $table) {
            $table->id();
            $table->char('counter_request_id', 18);
            $table->char('item_id', 5);
            $table->string('source');
            $table->char('counter_id', 5)->nullable();
            $table->char('warehouse_id', 5)->nullable();
            $table->integer('counter_request_quantity');
            $table->string('counter_request_approval');
            $table->text('counter_request_reason');
            $table->timestamps();

            $table->foreign('counter_request_id')
                ->references('counter_request_id')
                ->on('counter_requests')->onDelete('cascade');

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
        Schema::dropIfExists('counter_request_details');
    }
};
