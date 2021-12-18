<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToBacPakaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bac_pakai', function (Blueprint $table) {
            $table->enum('status', ['Belum Tervalidasi', 'Tervalidasi'])->after('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bac_pakai', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
