<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailTelpAndWebsiteToSettingAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setting_app', function (Blueprint $table) {
            $table->string('email', 100)->after('nama_perusahaan');
            $table->string('telp')->after('email');
            $table->string('website')->nullable()->after('telp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setting_app', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('telp');
            $table->dropColumn('website');
        });
    }
}
