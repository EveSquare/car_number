<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumberPlatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('number_plates', function (Blueprint $table) {
            $table->id();
            // $table->integer('user_id')->unsigned();
            $table->string('regional_name')->nullable();
            $table->integer('category_number')->nullable();
            $table->string('hiragana', 1)->nullable();
            $table->unsignedTinyInteger('specified_number_1')->nullable();
            $table->unsignedTinyInteger('specified_number_2')->nullable();
            $table->unsignedTinyInteger('specified_number_3')->nullable();
            $table->unsignedTinyInteger('specified_number_4')->nullable();
            $table->string('color')->nullable();
            $table->boolean('is_Active')->default(true);
            $table->boolean('is_Caution')->default(false);
            $table->timestamps();

            // $table->foreign('user_id')
            //     ->references('id')->on('users')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('number_plates');
    }
}
