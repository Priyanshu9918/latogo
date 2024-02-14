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
        Schema::create('book_sessions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('class_id')->index()->unsigned()->nullable();
            $table->bigInteger('student_id')->index()->unsigned()->nullable();
            $table->bigInteger('teacher_id')->index()->unsigned()->nullable();
            $table->dateTime('start_time', $precision = 0)->nullable();
            $table->dateTime('end_time', $precision = 0)->nullable();
            $table->longText('student_url')->nullable();
            $table->longText('teacher_url')->nullable();
            $table->longText('record_url')->nullable();
            $table->bigInteger('duration')->nullable();
            $table->tinyInteger('is_booked')->default('0')->nullable();
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
        Schema::dropIfExists('book_sessions');
    }
};
