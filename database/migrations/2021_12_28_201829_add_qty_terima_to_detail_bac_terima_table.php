<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQtyTerimaToDetailBacTerimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_bac_terima', function (Blueprint $table) {
            $table->integer('qty_terima')->nullable()->default(0)->after('qty');
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
            $table->dropColumn('qty_terima');
        });
    }
}
