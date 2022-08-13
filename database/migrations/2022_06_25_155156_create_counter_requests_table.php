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
        Schema::create('counter_requests', function (Blueprint $table) {
            $table->char('counter_request_id', 19);
            $table->primary('counter_request_id');
            $table->string('slug');
            $table->char('counter_id', 5);
            $table->date('counter_request_date');
            $table->string('counter_request_status');
            $table->timestamps();

            $table->foreign('counter_id')
                ->references('counter_id')
                ->on('counters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counter_requests');
    }
};
