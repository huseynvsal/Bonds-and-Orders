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
        Schema::create('bonds', function (Blueprint $table) {
            $table->id();
            $table->date('issue_date');
            $table->date('last_turnover_date');
            $table->integer('nominal_price');
            $table->enum('payment_frequency', [1, 2, 4, 12]);
            $table->enum('calculating_period', [360, 364, 365]);
            $table->tinyInteger('coupon_interest');
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
        Schema::dropIfExists('bonds');
    }
};
