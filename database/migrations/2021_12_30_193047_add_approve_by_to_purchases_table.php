<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApproveByToPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->foreignId('approve_by_gm')
                ->nullable()->after('supplier_id')
                ->constrained('users');

            $table->foreignId('approve_by_direktur')
                ->nullable()
                ->after('approve_by_gm')
                ->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign('approve_by_gm');
            $table->dropForeign('approve_by_direktur');
        });
    }
}
