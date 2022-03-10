<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHargaDemorageToSpalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spal', function (Blueprint $table) {
            $table->integer('harga_demorage')->after('harga_unit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spal', function (Blueprint $table) {
            $table->dropColumn('harga_demorage');
        });
    }
}
