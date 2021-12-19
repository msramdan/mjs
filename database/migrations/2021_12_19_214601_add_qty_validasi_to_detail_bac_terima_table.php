<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQtyValidasiToDetailBacTerimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_bac_terima', function (Blueprint $table) {
            $table->integer('qty_validasi')->after('qty')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_bac_terima', function (Blueprint $table) {
            $table->dropColumn('qty_validasi');
        });
    }
}
