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
        Schema::create('billing_details', function (Blueprint $table) {
            $table->id();
            $table->string('user_id',200)->nullable();
            $table->string('first_name',200)->nullable();
            $table->string('last_name',200)->nullable();
            $table->string('name',255)->nullable();
            $table->string('address')->nullable();
            $table->string('apartment_details')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('postal_code')->nullable();
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
        Schema::dropIfExists('billing_details');
    }
};
