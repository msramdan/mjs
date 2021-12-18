<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bac_pakai_id')->constrained('bac_pakai');
            $table->foreignId('validasi_by')->constrained('users');
            $table->date('tanggal_validasi');
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
        Schema::dropIfExists('aso');
    }
}
