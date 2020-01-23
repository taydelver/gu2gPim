<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionGroupValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_group_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sort_order')->default(0);
            $table->tinyInteger('is_default')->default(0);
            $table->unsignedBigInteger('option_value_id');
            $table->foreign('option_value_id')->references('id')->on('option_values');
            $table->unsignedBigInteger('option_group_id');
            $table->foreign('option_group_id')->references('id')->on('option_groups');
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
        Schema::dropIfExists('option_group_values');
    }
}
