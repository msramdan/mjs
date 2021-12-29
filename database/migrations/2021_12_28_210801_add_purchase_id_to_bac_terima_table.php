<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurchaseIdToBacTerimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bac_terima', function (Blueprint $table) {
            $table->foreignId('purchase_id')->after('user_id')->constrained('purchases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bac_terima', function (Blueprint $table) {
            $table->dropForeign('purchase_id');
        });
    }
}
