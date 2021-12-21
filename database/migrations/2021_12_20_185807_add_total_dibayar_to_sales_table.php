<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalDibayarToSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->tinyInteger('lunas')->default(0)->after('catatan');
            $table->integer('total_dibayar')->default(0)->after('lunas');
            // $table->integer('sisa')->after('total_dibayar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            // $table->dropColumn('staus_pembayaran');
            $table->dropColumn('total_dibayar');
            // $table->dropColumn('sisa');
        });
    }
}
