<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewFileBacTerimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_file_bac_terima', function (Blueprint $table) {
            $table->id();
            $table->foreignId('new_bac_terima_id')->constrained('new_bac_terima')->cascadeOnDelete();
            $table->string('nama', 100);
            $table->string('file', 100);
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
        Schema::dropIfExists('new_file_bac_terima');
    }
}
