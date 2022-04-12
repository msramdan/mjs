<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_app', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aplikasi', 100);
            $table->string('nama_perusahaan', 100);
            $table->string('alamat_perusahaan');
            $table->string('logo_perusahaan', 100)->nullable();
            $table->string('nama_direktur', 100);
            $table->string('password_un_lock_absensi', 200);
            $table->char('is_aktive_absensi', 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_app');
    }
}
