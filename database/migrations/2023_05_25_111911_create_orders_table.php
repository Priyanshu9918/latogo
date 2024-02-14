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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no',200)->index()->nullable();
            $table->bigInteger('user_id')->index()->nullable();
            $table->bigInteger('billing_id')->index()->nullable();
            $table->bigInteger('coupan_id')->index()->nullable();
            $table->string('transaction_id',200)->index()->nullable();
            $table->decimal('sub_total',10,2)->default('0')->nullable();
            $table->decimal('tax',10,2)->default('0')->nullable();
            $table->decimal('total_price',10,2)->default('0')->nullable();
            $table->string('billing_address',200)->nullable();
            $table->tinyInteger('status')->default('1')->comment('0 => Pending, 1 => Inprocessing, 2 => Delivered')->nullable();
            $table->dateTime('ordered_at')->nullable();
            $table->dateTime('assigned_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->dateTime('payment_received_at')->nullable();
            $table->enum('order_type',['online','offline'])->default('online')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
