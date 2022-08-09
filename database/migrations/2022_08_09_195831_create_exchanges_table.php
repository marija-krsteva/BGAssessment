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
        Schema::create('exchanges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_exchanged_id')->constrained()->onDelete('cascade');;
            $table->foreign('item_exchanged_id')->references('id')->on('items');

            $table->unsignedBigInteger('item_exchanged_into_id')->constrained()->onDelete('cascade');;
            $table->foreign('item_exchanged_into_id')->references('id')->on('items');

            $table->float('rate', 4, 2);

            $table->index('item_exchanged_id');
            $table->index('item_exchanged_into_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchanges');
    }
};
