<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnergyMeasurementsTable extends Migration
{
    public function up()
    {
        Schema::create('energy_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->binary('energy_value');
            $table->dateTime('measurement_datetime');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('energy_measurements');
    }
}
