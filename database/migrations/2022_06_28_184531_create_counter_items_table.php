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
        Schema::create('counter_items', function (Blueprint $table) {
            $table->char("counter_item_id", 10);
            $table->primary("counter_item_id");
            $table->string("slug");
            $table->char("item_id", 5);
            $table->char("counter_id", 5);
            $table->integer("stok_counter_item");
            $table->timestamps();

            $table->foreign("item_id")
                ->references("item_id")
                ->on("items")->onDelete("cascade");

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
        Schema::dropIfExists('counter_items');
    }
};
