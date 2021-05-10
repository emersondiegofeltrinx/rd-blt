<?php

use App\Models\Incident;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->string('title', 80);
            $table->mediumText('description');
            $table->enum('criticality', [
                Incident::CRITICALITY_HIGH,
                Incident::CRITICALITY_MEDIUM,
                Incident::CRITICALITY_LOW,
            ])->default(Incident::CRITICALITY_LOW);
            $table->enum('type', [
                Incident::TYPE_ALARM,
                Incident::TYPE_INCIDENT,
                Incident::TYPE_OTHER,
            ])->default(Incident::TYPE_OTHER);
            $table->enum('status', [
                Incident::STATUS_ACTIVE,
                Incident::STATUS_INACTIVE,
            ])->default(Incident::STATUS_ACTIVE);
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
        Schema::dropIfExists('incidents');
    }
}
