<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTimeSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_time_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('time_sheet_id')->constrained('time_sheets')->cascadeOnDelete();
            $table->date('date');
            $table->string('remark');
            $table->time('from');
            $table->time('to');
            $table->string('keterangan');
            $table->tinyInteger('is_count')->default(0);
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
        Schema::dropIfExists('detail_time_sheets');
    }
}
