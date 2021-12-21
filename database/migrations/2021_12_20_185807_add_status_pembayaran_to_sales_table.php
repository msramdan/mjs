<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusPembayaranToSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->enum('status_pembayaran', ['Unpaid', 'Paid', 'Pending'])->after('catatan');
            $table->integer('total_dibayar')->default(0)->after('status_pembayaran');
            $table->integer('sisa')->after('total_dibayar');
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
            $table->dropColumn('staus_pembayaran');
            $table->dropColumn('total_dibayar');
            $table->dropColumn('sisa');
        });
    }
}
