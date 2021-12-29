<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHargaAndSubtotalToDetailBacTerimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_bac_terima', function (Blueprint $table) {
            $table->integer('harga')->after('bac_terima_id');
            $table->integer('sub_total')->after('qty');
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
            $table->dropColumn('harga');
            $table->dropColumn('sub_total');
        });
    }
}
