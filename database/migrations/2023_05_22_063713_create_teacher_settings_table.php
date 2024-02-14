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
        Schema::create('teacher_settings', function (Blueprint $table) {
            $table->id();
            $table->Integer('user_id')->unsigned()->nullable();
            $table->string('avatar',600)->nullable();
            $table->string('youtube_link',1000)->nullable();
            $table->text('address_line_1')->nullable();
            $table->text('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('language')->nullable();
            $table->text('about_me')->nullable();
            $table->text('teacher_headline')->nullable();
            $table->text('me_as_teacher')->nullable();
            $table->text('my_teaching_style')->nullable();
            $table->tinyInteger('status')->default('1')->unsigned()->nullable();
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
        Schema::dropIfExists('teacher_settings');
    }
};
