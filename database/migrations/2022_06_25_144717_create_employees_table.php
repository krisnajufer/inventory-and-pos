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
        Schema::create('employees', function (Blueprint $table) {
            $table->char('employee_id', 5);
            $table->primary('employee_id');
            $table->string('slug');
            $table->string('user_id');
            $table->string('firstname');
            $table->string('lastname');
            $table->text('employee_address');
            $table->string('employee_city');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('phone_number')->unique();
            $table->string('role');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
