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
        Schema::create('warehouse_deliveries', function (Blueprint $table) {
            $table->char('warehouse_delivery_id', 18);
            $table->primary('warehouse_delivery_id');
            $table->string('slug');
            $table->char('warehouse_request_id', 18);
            $table->date('warehouse_delivery_date');
            $table->timestamps();

            $table->foreign('warehouse_request_id')
                ->references('warehouse_request_id')
                ->on('warehouse_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_deliveries');
    }
};
