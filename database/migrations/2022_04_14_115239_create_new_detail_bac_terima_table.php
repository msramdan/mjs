<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewDetailBacTerimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_detail_bac_terima', function (Blueprint $table) {
            $table->id();
            $table->foreignId('new_bac_terima_id')->constrained('new_bac_terima')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('items');
            $table->integer('qty_terima');
            $table->integer('qty_validasi')->default(0)->nullable();
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
        Schema::dropIfExists('new_detail_bac_terima');
    }
}
