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
        Schema::create('commutes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('office_id');
            $table->timestamps();
            $table->timestamp('arrival')->nullable();
            $table->timestamp('departure')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commutes');
    }
};
