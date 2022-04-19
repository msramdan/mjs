<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_request_id')->constrained('category_request');
            $table->integer('lokasi_id')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->string('kode', 30);
            $table->date('tanggal');
            $table->text('berita_acara');
            // 0 kalo ga ada purchase, 1 kalo udah ada purchase
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('request_forms');
    }
}
