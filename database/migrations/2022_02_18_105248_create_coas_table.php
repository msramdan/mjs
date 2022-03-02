<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coas', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30);
            $table->string('nama', 50);
            $table->enum('tipe', [
                'Asset',
                'Bank',
                'Account Receivable',
                'Fixed Assets',
                'Liability',
                'Account Payable',
                'Long Term Liability',
                'Euqity',
                'Income',
                'Expense',
                'Other Current Asset',
                'Other Income',
                'Other Expenses'
            ]);
            $table->enum('kategori', [
                'Parent',
                'Header',
                'Detail'
            ]);
            $table->tinyInteger('parent')->nullable();
            $table->string('type_report', 30)->nullable();
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
        Schema::dropIfExists('coas');
    }
}
