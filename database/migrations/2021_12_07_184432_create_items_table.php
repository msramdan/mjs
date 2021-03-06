<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('unit_id')->constrained('units');
            // $table->foreignId('akun_coa_id')->constrained('account_coa');
            $table->string('kode', 30);
            $table->string('nama', 100);
            $table->string('type', 20);
            $table->text('deskripsi')->nullable();
            $table->integer('stok')->nullable()->default(0);
            $table->string('foto')->nullable();
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
        Schema::dropIfExists('items');
    }
}
