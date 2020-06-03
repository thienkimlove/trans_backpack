<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMachines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->unsignedBigInteger('bank_id');
            $table->unsignedBigInteger('max_amount_per_date')->nullable();
            $table->unsignedBigInteger('max_amount_per_trans')->nullable();
            $table->unsignedSmallInteger('fee_percent_per_trans');
            $table->timestamps();
        });

        Schema::create('bank_machine', function (Blueprint $table) {
            $table->unsignedBigInteger('bank_id');
            $table->unsignedBigInteger('machine_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_machine');
        Schema::dropIfExists('machines');
    }
}
