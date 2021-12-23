<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained('purchases');
            $table->foreignId('user_id')->constrained('users');
            $table->string('kode', 30);
            $table->string('attn', 30);
            $table->date('tanggal_billing');
            $table->date('tanggal_dibayar')->nullable();
            $table->integer('dibayar');
            $table->enum('status', ['Unpaid', 'Paid']);
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
        Schema::dropIfExists('biliings');
    }
}
