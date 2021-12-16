<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileBacPakaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_bac_pakai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bac_pakai_id')->constrained('bac_pakai');
            $table->string('nama', 50);
            $table->string('file', 50);
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
        Schema::dropIfExists('file_bac_pakais');
    }
}
