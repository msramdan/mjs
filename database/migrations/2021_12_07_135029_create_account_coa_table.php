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
            $table->string('code_account_coa');
            $table->string('account_coa');
            $table->foreignId('account_header_id')->constrained('account_header');
            $table->string('normal');
            $table->string('remark');
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
