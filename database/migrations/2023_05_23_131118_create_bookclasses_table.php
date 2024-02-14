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
        Schema::create('bookclasses', function (Blueprint $table) {
            $table->id();
            $table->string('youtube_url',200)->nullable();
            $table->longText('description')->nullable();
            $table->string('Teacher_id',200)->nullable();
            $table->string('degination',200)->nullable();
            $table->string('Teaches',200)->nullable();
            $table->string('student_count')->nullable();
            $table->string('lessons')->nullable();
            $table->string('success')->nullable();
            $table->tinyInteger('status')->default('0')->comment('0 => Inactive, 1 => Active, 2 => Deleted')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookclasses');
    }
};
