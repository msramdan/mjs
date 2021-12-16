<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailBacTerimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_bac_terima', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bac_terima_id')->constrained('bac_terima');
            $table->foreignId('item_id')->constrained('items');
            $table->integer('qty');
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
        Schema::dropIfExists('detail_bac_terimas');
    }
}
