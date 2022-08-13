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
        Schema::create('counter_deliveries', function (Blueprint $table) {
            $table->char('counter_delivery_id', 19);
            $table->primary('counter_delivery_id');
            $table->string('slug');
            $table->char('counter_request_id', 5);
            $table->date('counter_delivery_date');
            $table->timestamps();

            $table->foreign('counter_request_id')
                ->references('counter_request_id')
                ->on('counter_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counter_deliveries');
    }
};
