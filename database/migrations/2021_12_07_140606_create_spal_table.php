<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('kode', 30);
            $table->string('nama_kapal', 100);
            $table->string('nama_muatan', 100);
            $table->integer('jml_muatan');
            $table->string('pelabuhan_muat', 100);
            $table->string('pelabuhan_bongkar', 100);
            $table->integer('harga_unit');
            $table->string('file', 100);
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
        Schema::dropIfExists('spals');
    }
}
