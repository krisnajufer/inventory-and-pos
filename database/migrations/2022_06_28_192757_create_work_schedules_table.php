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
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->char("work_schedule_id", 19);
            $table->primary("work_schedule_id");
            $table->char("employee_id", 5);
            $table->char("warehouse_id", 5)->nullable();
            $table->char("counter_id", 5)->nullable();
            $table->date("working_date");
            $table->timestamps();

            $table->foreign("employee_id")
                ->references("employee_id")
                ->on("employees")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_schedules');
    }
};
