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
        Schema::create('warehouse_requests', function (Blueprint $table) {
            $table->char('warehouse_request_id', 18);
            $table->primary('warehouse_request_id');
            $table->string('slug');
            $table->char('warehouse_id', 5);
            $table->date('warehouse_request_date');
            $table->string('warehouse_request_status');
            $table->timestamps();

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
        Schema::dropIfExists('warehouse_requests');
    }
};
