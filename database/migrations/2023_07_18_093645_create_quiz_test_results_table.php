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
        Schema::create('quiz_test_results', function (Blueprint $table) {
            $table->id();
            $table->string('user_id',200)->nullable();
            $table->string('quiz_id',200)->nullable();
            $table->string('url',4000)->nullable();
            $table->string('raw_data',5000)->nullable();
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
        Schema::dropIfExists('quiz_test_results');
    }
};
