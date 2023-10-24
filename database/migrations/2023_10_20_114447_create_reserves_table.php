<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reserves', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('hotelCode');
            $table->unsignedBigInteger('roomCode');
            $table->date('checkIn');
            $table->date('checkOut');
            $table->decimal('total');
            $table->foreign('hotelCode')->references('id')->on('hotels')->onDelete('cascade');
            $table->foreign('roomCode')->references('id')->on('rooms')->onDelete('cascade');

        });

        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('lastName');
            $table->string('phone');
            $table->unsignedBigInteger('reserves_id');
            $table->foreign('reserves_id')->references('id')->on('reserves')->onDelete('cascade');

        });

        Schema::create('dailies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date');
            $table->decimal('value');
            $table->unsignedBigInteger('reserves_id');
            $table->foreign('reserves_id')->references('id')->on('reserves')->onDelete('cascade');
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('method');
            $table->decimal('value');
            $table->unsignedBigInteger('reserves_id');
            $table->foreign('reserves_id')->references('id')->on('reserves')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserves');
    }
};
