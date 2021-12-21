<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountCoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_coa', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30);
            $table->string('nama', 50);
            $table->foreignId('account_header_id')->constrained('account_header');
            $table->string('normal', 30);
            $table->string('remark', 50);
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
        Schema::dropIfExists('account_coa');
    }
}
