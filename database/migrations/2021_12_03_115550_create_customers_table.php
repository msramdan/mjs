<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20);
            $table->string('nama', 100);
            $table->string('email', 191);
            $table->text('alamat');
            $table->string('kota', 30);
            $table->string('provinsi', 30);
            $table->string('telp', 20);
            $table->string('personal_kontak', 20)->nullable();
            $table->string('website', 100)->nullable();
            $table->string('kode_pos', 20)->nullable();
            $table->text('catatan')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
