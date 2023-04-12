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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->foreignId('partner_id');
            $table->string('slug')->unique();
            $table->string('title');
            $table->date('expiration');
            $table->string('image')->default('default/no_image.jpg');
            $table->text('excerpt');
            $table->text('description');
            $table->unsignedBigInteger('og_price');
            $table->unsignedBigInteger('discounted_price');
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
        Schema::dropIfExists('coupons');
    }
};
